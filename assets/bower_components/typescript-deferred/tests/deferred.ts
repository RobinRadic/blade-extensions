///<reference path="../typings/node/node.d.ts"/>
///<reference path="./interface/mocha.d.ts"/>

import tsd = require('../typescript_deferred');
import assert = require('assert');

suite('typescript-deferred::Deferred', function() {

    this.timeout(100);

    suite('multiple resolutions / rejects: the first one wins', function() {
        var rejectCalled: number,
            resolveCalled: number,
            reason: string,
            value: string,
            deferred: tsd.DeferredInterface<string>;

        setup(function() {
            rejectCalled = resolveCalled = 0;
            reason = value = '';

            deferred = tsd.create<string>();

            deferred.promise.then(
                (v: string) => (value = v, resolveCalled++),
                (r: string) => (reason = r, rejectCalled++)
            );
        });

        test('double resolve', function(done) {
            deferred.resolve('foo').resolve('bar');

            setTimeout(
                function(): void {
                    try {
                        assert.strictEqual(rejectCalled, 0, 'reject should not have been called');
                        assert.strictEqual(resolveCalled, 1, 'resolve should have been called once');
                        assert.strictEqual(value, 'foo', 'the first resolve should have won');
                    } catch (e) {
                        return done(e);
                    }

                    done();
                }, 50
            );
        });

        test('resolve, reject', function(done) {            
            deferred.resolve('foo').reject('bar');

            setTimeout(
                function(): void {
                    try {
                        assert.strictEqual(rejectCalled, 0, 'reject should not have been called');
                        assert.strictEqual(resolveCalled, 1, 'resolve should have been called once');
                        assert.strictEqual(value, 'foo', 'resolve should have won');
                    } catch (e) {
                        return done(e);
                    }

                    done();
                }, 50
            );
        });

        test('reject, resolve', function(done) {            
            deferred.reject('foo').resolve('bar');

            setTimeout(
                function(): void {
                    try {
                        assert.strictEqual(rejectCalled, 1, 'reject should have been called once');
                        assert.strictEqual(resolveCalled, 0, 'resolve should not have been called');
                        assert.strictEqual(reason, 'foo', 'reject should have won');
                    } catch (e) {
                        return done(e);
                    }

                    done();
                }, 50
            );
        });

        test('double reject', function(done) {            
            deferred.reject('foo').reject('bar');

            setTimeout(
                function(): void {
                    try {
                        assert.strictEqual(rejectCalled, 1, 'reject should have been called once');
                        assert.strictEqual(resolveCalled, 0, 'resolve should not have been called');
                        assert.strictEqual(reason, 'foo', 'the first reject should have won');
                    } catch (e) {
                        return done(e);
                    }

                    done();
                }, 50
            );
        });

    });

});
