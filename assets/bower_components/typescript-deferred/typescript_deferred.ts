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

export interface ImmediateSuccessCB<T, TP> {
    (value: T): TP;
}

export interface ImmediateErrorCB<TP> {
    (err: any): TP;
}

export interface DeferredSuccessCB<T, TP> {
    (value: T): ThenableInterface<TP>;
}

export interface DeferredErrorCB<TP> {
    (error: any): ThenableInterface<TP>;
}

export interface ThenableInterface<T> {
    then<TP>(
            successCB?:  DeferredSuccessCB<T, TP>,
            errorCB?:    DeferredErrorCB<TP>
        ): ThenableInterface<TP>;

    then<TP>(
            successCB?:   DeferredSuccessCB<T, TP>,
            errorCB?:   ImmediateErrorCB<TP>
        ): ThenableInterface<TP>;

    then<TP>(
            successCB?:  ImmediateSuccessCB<T, TP>,
            errorCB?:    DeferredErrorCB<TP>
        ): ThenableInterface<TP>;

    then<TP>(
            successCB?:  ImmediateSuccessCB<T, TP>,
            errorCB?:   ImmediateErrorCB<TP>
        ): ThenableInterface<TP>;
}

export interface PromiseInterface<T> extends ThenableInterface<T> {
    then<TP>(
            successCB?:  DeferredSuccessCB<T, TP>,
            errorCB?:    DeferredErrorCB<TP>
        ): PromiseInterface<TP>;

    then<TP>(
            successCB?:   DeferredSuccessCB<T, TP>,
            errorCB?:   ImmediateErrorCB<TP>
        ): PromiseInterface<TP>;

    then<TP>(
            successCB?:  ImmediateSuccessCB<T, TP>,
            errorCB?:    DeferredErrorCB<TP>
        ): PromiseInterface<TP>;

    then<TP>(
            successCB?:  ImmediateSuccessCB<T, TP>,
            errorCB?:   ImmediateErrorCB<TP>
        ): PromiseInterface<TP>;


    otherwise(errorCB?: DeferredErrorCB<T>) : PromiseInterface<T>;

    otherwise(errorCB?: ImmediateErrorCB<T>): PromiseInterface<T>;

    always<TP>(errorCB?: DeferredErrorCB<TP>) : PromiseInterface<TP>;

    always<TP>(errorCB?: ImmediateErrorCB<TP>): PromiseInterface<TP>;
}

export interface DeferredInterface<T> {
    resolve(value?: ThenableInterface<T>): DeferredInterface<T>;

    resolve(value?: T): DeferredInterface<T>;

    reject(error?: any): DeferredInterface<T>;

    promise: PromiseInterface<T>;
}

export function create<T>(): DeferredInterface<T> {
    return new Deferred(DispatchDeferred);
}

export function when<T>(value?: ThenableInterface<T>): PromiseInterface<T>;

export function when<T>(value?: T): PromiseInterface<T>;

export function when(value?: any): any {
    if (value instanceof Promise) {
        return value;
    }
    return create().resolve(value).promise;
}

interface DispatcherInterface {
    (closure: () => void): void;
}

function DispatchDeferred(closure: () => void) {
    setTimeout(closure, 0);
}

enum PromiseState {Pending, ResolutionInProgress, Resolved, Rejected}

class Client {
    constructor(
           private _dispatcher: DispatcherInterface,
           private _successCB: any,
           private _errorCB: any
        )
    {
        this.result = new Deferred<any>(_dispatcher);
    }

    resolve(value: any, defer: boolean): void {
        if (typeof(this._successCB) !== 'function') {
            this.result.resolve(value);
            return;
        }

        if (defer) {
            this._dispatcher(() => this._dispatchCallback(this._successCB, value));
        } else {
            this._dispatchCallback(this._successCB, value);
        }
    }

    reject(error: any, defer: boolean): void {
        if (typeof(this._errorCB) !== 'function') {
            this.result.reject(error);
            return;
        }

        if (defer) {
            this._dispatcher(() => this._dispatchCallback(this._errorCB, error));
        } else {
            this._dispatchCallback(this._errorCB, error);
        }
    }

    private _dispatchCallback(callback: (arg: any) => any, arg: any): void {
        var result: any,
            then: any,
            type: string;

        try {
            result = callback(arg);
            this.result.resolve(result);
        } catch (err) {
            this.result.reject(err);
            return;
        }
    }

    result: DeferredInterface<any>;
}

class Deferred<T> implements DeferredInterface<T> {
    constructor(private _dispatcher: DispatcherInterface) {
        this.promise = new Promise<T>(this);
    }

    _then(successCB: any, errorCB: any): any
    {
        if (typeof(successCB) !== 'function' && typeof(errorCB) !== 'function') {
            return this.promise;
        }

        var client = new Client(this._dispatcher, successCB, errorCB);

        switch(this._state) {
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
    }

    resolve(value?: T): DeferredInterface<T>;

    resolve(value?: PromiseInterface<T>): DeferredInterface<T>;

    resolve(value?: any): DeferredInterface<T> {
        if (this._state !== PromiseState.Pending) {
            return this;
        }

        return this._resolve(value);
    }

    private _resolve(value: any): DeferredInterface<T> {
        var type = typeof(value),
            then: any,
            pending = true;

        try {
            if (    value !== null &&
                    (type === 'object' || type === 'function') &&
                    typeof(then = value.then) === 'function') 
            {
                if (value === this.promise) {
                    throw new TypeError('recursive resolution');
                }

                this._state = PromiseState.ResolutionInProgress;
                then.call(value,
                    (result: any): void => {
                        if (pending) {
                            pending = false;
                            this._resolve(result);
                        }
                    },
                    (error: any): void => {
                        if (pending) {
                            pending = false;
                            this._reject(error);
                        }
                    }
                );
            } else {
                this._state = PromiseState.ResolutionInProgress;

                this._dispatcher(() => {
                    this._state = PromiseState.Resolved;
                    this._value = value;

                    var i: number,
                        stackSize = this._stack.length;

                    for (i = 0; i < stackSize; i++) {
                        this._stack[i].resolve(value, false);
                    }

                    this._stack.splice(0, stackSize);
                });
            }
        } catch (err) {
            if (pending) {
                this._reject(err);
            }
        }

        return this;
    }

    reject(error?: any): DeferredInterface<T> {
        if (this._state !== PromiseState.Pending) {
            return this;
        }

        return this._reject(error);
    }

    private _reject(error?: any): DeferredInterface<T> {
        this._state = PromiseState.ResolutionInProgress;

        this._dispatcher(() => {
            this._state = PromiseState.Rejected;
            this._error = error;

            var stackSize = this._stack.length,
                i = 0;

            for (i = 0; i < stackSize; i++) {
                this._stack[i].reject(error, false);
            }

            this._stack.splice(0, stackSize);
        });

        return this;
    }

    promise: PromiseInterface<T>;

    private _stack: Array<Client> = [];
    private _state = PromiseState.Pending;
    private _value: T;
    private _error: any;
}

class Promise<T> implements PromiseInterface<T> {
    constructor(private _deferred: Deferred<T>) {}

    then<TP>(
            successCB?:  DeferredSuccessCB<T, TP>,
            errorCB?:    DeferredErrorCB<TP>
        ): PromiseInterface<TP>;

    then<TP>(
            successCB?:   DeferredSuccessCB<T, TP>,
            errorCB?:   ImmediateErrorCB<TP>
        ): PromiseInterface<TP>;

    then<TP>(
            successCB?:  ImmediateSuccessCB<T, TP>,
            errorCB?:    DeferredErrorCB<TP>
        ): PromiseInterface<TP>;

    then<TP>(
            successCB?:  ImmediateSuccessCB<T, TP>,
            errorCB?:   ImmediateErrorCB<TP>
        ): PromiseInterface<TP>;

    then(successCB: any, errorCB: any): any
    {
        return this._deferred._then(successCB, errorCB);
    }

    otherwise(errorCB?: ImmediateErrorCB<T>): PromiseInterface<T>;

    otherwise(errorCB?: DeferredErrorCB<T>) : PromiseInterface<T>;

    otherwise(errorCB: any): any {
        return this._deferred._then(undefined, errorCB);
    }

    always<TP>(errorCB?: ImmediateErrorCB<TP>): PromiseInterface<TP>;

    always<TP>(errorCB?: DeferredErrorCB<TP>) : PromiseInterface<TP>;

    always<TP>(errorCB?: any): any {
        return this._deferred._then(errorCB, errorCB);
    }
}
