pipeline {
  agent any
  stages {
    stage('install') {
      steps {
        sh 'composer install'
      }
    }
    stage('test') {
      steps {
        sh 'phpunit'
      }
    }
    stage('Deploy') {
      steps {
        input(message: 'Want to deploy?', id: 'deploy', ok: 'ok')
        waitUntil() {
          echo 'b'
        }
        
      }
    }
  }
  environment {
    a = 'n'
  }
}