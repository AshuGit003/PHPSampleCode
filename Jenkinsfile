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
                // Uses a highly stable, lightweight official Linux image
                docker { image 'alpine:latest' } 
            }
            steps {
                echo 'Installing LFTP and deploying files securely...'
                sh '''
                    # Install lftp using the Alpine package manager
                    apk add --no-cache lftp
                    
                    # Run the deployment mirror script
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