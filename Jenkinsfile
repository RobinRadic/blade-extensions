pipeline {
    agent any
    stages {
        stage('Checkout Sources') {
            steps {
                checkout scm
            }
        }
        stage('Prepare files') {
            steps {
                sh 'rm -rf vendor composer.lock'
            }
        }
        stage('Install Build Tools') {
            steps {
                sh '''php -r "copy(\'https://getcomposer.org/installer\', \'composer-setup.php\');"
php -r "if (hash_file(\'SHA384\', \'composer-setup.php\') === \'544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061\') { echo \'Installer verified\'; } else { echo \'Installer corrupt\'; unlink(\'composer-setup.php\'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink(\'composer-setup.php\');"'''
            }
        }
        stage('Install Dependencies') {
            steps {
                sh 'php composer.phar install'
            }
        }
        stage('Unit Tests') {
            steps {
                sh 'php vendor/bin/phpunit'
            }
        }
        stage('Scan Code Quality') {
            steps {
                tool 'sonar-scanner'
                script {
                    def scannerHome = tool('sonar-scanner')
                    withSonarQubeEnv('radic-sonar') {
                        sh "${scannerHome}/bin/sonar-scanner"
                    }
                }

            }
        }
        stage('Check Quality') {
            steps {
                script {

                    timeout(time: 10, unit: 'MINUTES') { // Just in case something goes wrong, pipeline will be killed after a timeout
                        def qg = waitForQualityGate() // Reuse taskId previously collected by withSonarQubeEnv
                        if (qg.status != 'OK') {
                            error "Pipeline aborted due to quality gate failure: ${qg.status}"
                        }
                    }
                }

            }
        }
    }

    post {
        always {
            junit 'ci/codeCoverage/junit-logfile.xml'
            publishHTML([allowMissing: true, alwaysLinkToLastBuild: false, keepAll: true, reportDir: 'ci/codeCoverage/testdox', reportFiles: 'testdox.html', reportName: 'Agile Test Output', reportTitles: 'index'])
        }
    }
}