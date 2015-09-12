/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Christian Speckner
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */
'use strict';
(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports"], function (require, exports) {
    function create() {
        return new Deferred(DispatchDeferred);
    }
    exports.create = create;
    function when(value) {
        if (value instanceof Promise) {
            return value;
        }
        return create().resolve(value).promise;
    }
    exports.when = when;
    function DispatchDeferred(closure) {
        setTimeout(closure, 0);
    }
    var PromiseState;
    (function (PromiseState) {
        PromiseState[PromiseState["Pending"] = 0] = "Pending";
        PromiseState[PromiseState["ResolutionInProgress"] = 1] = "ResolutionInProgress";
        PromiseState[PromiseState["Resolved"] = 2] = "Resolved";
        PromiseState[PromiseState["Rejected"] = 3] = "Rejected";
    })(PromiseState || (PromiseState = {}));
    var Client = (function () {
        function Client(_dispatcher, _successCB, _errorCB) {
            this._dispatcher = _dispatcher;
            this._successCB = _successCB;
            this._errorCB = _errorCB;
            this.result = new Deferred(_dispatcher);
        }
        Client.prototype.resolve = function (value, defer) {
            var _this = this;
            if (typeof (this._successCB) !== 'function') {
                this.result.resolve(value);
                return;
            }
            if (defer) {
                this._dispatcher(function () { return _this._dispatchCallback(_this._successCB, value); });
            }
            else {
                this._dispatchCallback(this._successCB, value);
            }
        };
        Client.prototype.reject = function (error, defer) {
            var _this = this;
            if (typeof (this._errorCB) !== 'function') {
                this.result.reject(error);
                return;
            }
            if (defer) {
                this._dispatcher(function () { return _this._dispatchCallback(_this._errorCB, error); });
            }
            else {
                this._dispatchCallback(this._errorCB, error);
            }
        };
        Client.prototype._dispatchCallback = function (callback, arg) {
            var result, then, type;
            try {
                result = callback(arg);
                this.result.resolve(result);
            }
            catch (err) {
                this.result.reject(err);
                return;
            }
        };
        return Client;
    })();
    var Deferred = (function () {
        function Deferred(_dispatcher) {
            this._dispatcher = _dispatcher;
            this._stack = [];
            this._state = PromiseState.Pending;
            this.promise = new Promise(this);
        }
        Deferred.prototype._then = function (successCB, errorCB) {
            if (typeof (successCB) !== 'function' && typeof (errorCB) !== 'function') {
                return this.promise;
            }
            var client = new Client(this._dispatcher, successCB, errorCB);
            switch (this._state) {
                case PromiseState.Pending:
                case PromiseState.ResolutionInProgress:
                    this._stack.push(client);
                    break;
                case PromiseState.Resolved:
                    client.resolve(this._value, true);
                    break;
                case PromiseState.Rejected:
                    client.reject(this._error, true);
                    break;
            }
            return client.result.promise;
        };
        Deferred.prototype.resolve = function (value) {
            if (this._state !== PromiseState.Pending) {
                return this;
            }
            return this._resolve(value);
        };
        Deferred.prototype._resolve = function (value) {
            var _this = this;
            var type = typeof (value), then, pending = true;
            try {
                if (value !== null &&
                    (type === 'object' || type === 'function') &&
                    typeof (then = value.then) === 'function') {
                    if (value === this.promise) {
                        throw new TypeError('recursive resolution');
                    }
                    this._state = PromiseState.ResolutionInProgress;
                    then.call(value, function (result) {
                        if (pending) {
                            pending = false;
                            _this._resolve(result);
                        }
                    }, function (error) {
                        if (pending) {
                            pending = false;
                            _this._reject(error);
                        }
                    });
                }
                else {
                    this._state = PromiseState.ResolutionInProgress;
                    this._dispatcher(function () {
                        _this._state = PromiseState.Resolved;
                        _this._value = value;
                        var i, stackSize = _this._stack.length;
                        for (i = 0; i < stackSize; i++) {
                            _this._stack[i].resolve(value, false);
                        }
                        _this._stack.splice(0, stackSize);
                    });
                }
            }
            catch (err) {
                if (pending) {
                    this._reject(err);
                }
            }
            return this;
        };
        Deferred.prototype.reject = function (error) {
            if (this._state !== PromiseState.Pending) {
                return this;
            }
            return this._reject(error);
        };
        Deferred.prototype._reject = function (error) {
            var _this = this;
            this._state = PromiseState.ResolutionInProgress;
            this._dispatcher(function () {
                _this._state = PromiseState.Rejected;
                _this._error = error;
                var stackSize = _this._stack.length, i = 0;
                for (i = 0; i < stackSize; i++) {
                    _this._stack[i].reject(error, false);
                }
                _this._stack.splice(0, stackSize);
            });
            return this;
        };
        return Deferred;
    })();
    var Promise = (function () {
        function Promise(_deferred) {
            this._deferred = _deferred;
        }
        Promise.prototype.then = function (successCB, errorCB) {
            return this._deferred._then(successCB, errorCB);
        };
        Promise.prototype.otherwise = function (errorCB) {
            return this._deferred._then(undefined, errorCB);
        };
        Promise.prototype.always = function (errorCB) {
            return this._deferred._then(errorCB, errorCB);
        };
        return Promise;
    })();
});
