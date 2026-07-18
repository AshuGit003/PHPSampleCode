pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('PHP Syntax Check') {
            agent {
                docker { image 'php:8.2-cli' } // Spins up a temporary official PHP container
            }
            steps {
                echo 'Checking PHP files for syntax errors...'
                sh 'php -l index.php' // Runs inside the temporary PHP container
            }
        }

        stage('Deploy to InfinityFree') {
            steps {
                ftpPublisher(
                    alwaysPublishFromMaster: false,
                    continueOnError: false,
                    failOnError: true,
                    masterNodeName: '',
                    paramPublish: [parameterName: ''],
                    publishers: [
                        [
                            configName: 'infinityfree',
                            transfers: [
                                [
                                    sourceFiles: '**/*',
                                    excludes: '.git/**, Jenkinsfile, README.md',
                                    remoteDirectory: 'htdocs',
                                    removePrefix: '',
                                    flatten: false
                                ]
                            ],
                            useWorkspaceInPromotion: false,
                            usePromotionTimestamp: false
                        ]
                    ]
                )
            }
        }
    }

    post {
        success {
            echo 'Deployed to dummy-php.infinityfree.me'
        }
        failure {
            echo 'Deploy failed - check logs'
        }
    }
}