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
            agent {
                // Uses a lightweight Docker container that already has LFTP installed
                docker { image 'mwgamera/lftp' } 
            }
            steps {
                echo 'Deploying files securely via LFTP...'
                sh '''
                    lftp -c "
                    set ftp:passive-mode true;
                    set ftp:ssl-allow false;
                    open -u 'if0_42438585','C5u4b3lKP8D5Zp' ftpupload.net;
                    mirror -R --exclude .git/ --exclude Jenkinsfile --exclude README.md ./ /htdocs;
                    quit
                    "
                '''
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