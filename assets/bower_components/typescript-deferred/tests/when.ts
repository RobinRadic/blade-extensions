///<reference path="../typings/node/node.d.ts"/>
///<reference path="./interface/mocha.d.ts"/>

import tsd = require('../typescript_deferred');
import assert = require('assert');
import util = require('util');

function createResolvingPseudoThenable<T>(value: T): tsd.ThenableInterface<T> {
    return <any>{
        then: function(successCB: Function) {
            successCB(value);
        }
    };
}

function createRejectingPseudoThenable<T>(value: T): tsd.ThenableInterface<T> {
    return <any>{
        then: function(successCB: Function, errorCB: Function) {
            errorCB(value);
        }
    };
}

function assertResolvesTo<T>(
        promise: tsd.PromiseInterface<T>,
        value: T,
        done: Mocha.ReadyCallback
    ): void
{
    promise.then(function(result: T) {
        try {
            assert.strictEqual(value, result, util.format(
                'value was not transferred correctly, expected %s, got %s', value ,result)
            );
        } catch (e) {
            return done(e);
        }

        done();
    });
}

function assertRejectsTo(
        promise: tsd.PromiseInterface<any>,
        value: any,
        done: Mocha.ReadyCallback
    ): void
{
    promise.then(undefined, function(reason: any) {
        try {
            assert.strictEqual(value, reason, util.format(
                'reason was not transferred correctly, expected %s, got %s', value ,reason)
            );
        } catch (e) {
            return done(e);
        }

        done();
    });
}

suite('typescript-deferred::when', function() {

    this.timeout(100);

    test('no argument', function(done) {
        tsd.when().then((): void => done());
    });

    test('plain argument', function(done) {
        assertResolvesTo(tsd.when('foo'), 'foo', done)
    });

    test('thenable argument, resolves', function(done) {
        assertResolvesTo(tsd.when<string>(createResolvingPseudoThenable('foo')), 'foo', done);    
    });

    test('thenable argument, rejects', function(done) {
        assertRejectsTo(tsd.when<string>(createRejectingPseudoThenable('foo')), 'foo', done);
    });

    test('tsd promise, resolves', function(done) {
        var deferred = tsd.create<string>();

        assertResolvesTo(tsd.when<string>(deferred.promise), 'foo', done);

        deferred.resolve('foo');
    });

    test('tsd promise, rejects', function(done) {
        var deferred = tsd.create<number>();

        assertRejectsTo(tsd.when<number>(deferred.promise), 'foo', done);

        deferred.reject('foo');
    });
});
