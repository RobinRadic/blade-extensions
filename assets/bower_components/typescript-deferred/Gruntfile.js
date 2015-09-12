module.exports = function(grunt) {

    grunt.loadNpmTasks('grunt-ts');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-wrap');
    grunt.loadNpmTasks('grunt-text-replace');
    grunt.loadNpmTasks('grunt-tsd');
    grunt.loadNpmTasks('grunt-mocha-test');

    grunt.initConfig({
        ts: {
            main: {
                src: ['typescript_deferred.ts'],
                options: {
                    target: 'es3',
                    module: 'commonjs',
                    declaration: true,
                    sourceMap: false,
                    removeComments: true,
                    noImplicitAny: true
                }
            },
            test: {
                src: ['tests/*.ts'],
                options: {
                    target: 'es5',
                    module: 'commonjs',
                    declaration: false,
                    sourceMap: false,
                    removeComments: true,
                    noImplicitAny: true
                }
            }
        },

        tsd: {
            refresh: {
                options: {
                    command: 'reinstall',
                    latest: false,
                    config: 'tsd.json'
                }
            }
        },

        browserify: {
            main: {
                src: ['typescript_deferred.js'],
                dest: 'build/typescript_deferred.js',
                options: {
                    browserifyOptions: {
                        standalone: 'typescriptDeferred'
                    }
                }
            }
        },

        uglify: {
            main: {
                src: 'build/typescript_deferred.js',
                dest: 'build/typescript_deferred.min.js'
            }
        },

        mochaTest: {
            main: {
                options: {
                    reporter: 'spec',
                    ui: 'tdd',
                    bail: true
                },
                src: ['tests/*.js']
            }
        },

        wrap: {
            main: {
                src: 'typescript_deferred.d.ts',
                dest: 'typescript_deferred.d.ts',
                options: {
                    wrapper: ['declare module "typescript-deferred" {\n', '\n}\n']
                }
            },
            build: {
                src: 'typescript_deferred.d.ts',
                dest: 'build/typescript_deferred.d.ts',
                options: {
                    wrapper: ['declare module "typescript-deferred" {\n', '\n}\n']
                }
            },
            build_standalone: {
                src: 'typescript_deferred.d.ts',
                dest: 'build/typescript_deferred_standalone.d.ts',
                options: {
                    wrapper: ['declare module typescriptDeferred {\n', '\n}\n']
                }
            },
            options: {
                indent: '    '
            }
        },

        replace: {
            main: {
                src: 'typescript_deferred.d.ts',
                dest: 'typescript_deferred.d.ts',
                replacements: [{
                    from: /declare /g,
                    to: ''
                }]
            }
        },

        clean: {
            main: ['.tscache', 'typescript_deferred.js', 'typescript_deferred.d.ts', 'build', 'tests/**/*.js'],
            mrproper: ['typings']
        }
    });

    grunt.registerTask('aplus-suite', 'Run the Promises/A+ test suite', function() {
        var testHarness = require('./test_harness'),
            promisesAplusTests = require('promises-aplus-tests');

        var done = this.async();

        promisesAplusTests(testHarness, function(err) {
            done(!err);
        });
    });

    grunt.registerTask('default', ['build']);
    grunt.registerTask('build', ['clean:main', 'ts:main', 'replace', 'wrap:build', 'wrap:build_standalone', 'wrap:main', 'browserify', 'uglify']);
    grunt.registerTask('test', ['ts', 'aplus-suite', 'mochaTest']);
    grunt.registerTask('initial', ['clean', 'tsd']);
};
