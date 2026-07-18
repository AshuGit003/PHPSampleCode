pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('PHP Syntax Check') {
            steps {
                bat 'echo Skipping php -l if PHP not installed on agent, or run: php -l index.php'
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