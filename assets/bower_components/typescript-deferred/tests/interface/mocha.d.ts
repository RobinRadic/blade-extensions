declare function suite(name: string, implementation: Mocha.SuiteImplementation): void;

declare function test(name:string, implementation: Mocha.TestImplementation): void;

declare function setup(implementation: Mocha.SetupImplementation): void;

declare function teardown(implementation: Mocha.TeardownImplementation): void;

declare module Mocha {

    export interface ReadyCallback {
        (e?: any): void;
    }

    export interface SuiteImplementation {
        (): void;
    }

    export interface TestImplementation {
        (cb: ReadyCallback): void;
    }

    export interface SetupImplementation {
        (cb: ReadyCallback): void;
    }

    export interface TeardownImplementation {
        (cb: ReadyCallback): void;
    }

}
