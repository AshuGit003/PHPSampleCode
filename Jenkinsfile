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
                docker { image 'alpine:latest' } 
            }
            steps {
                echo 'Installing LFTP and deploying with speed optimizations...'
                sh '''
                    apk add --no-cache lftp
                    
                    lftp -c "
                    set ftp:passive-mode true;
                    set ftp:ssl-allow false;
                    
                    # SPEED OPTIMIZATIONS 👇
                    set net:timeout 10;
                    set net:max-retries 2;
                    set net:reconnect-interval-base 5;
                    
                    open -u 'if0_42438585','C5u4b3lKP8D5Zp' ftpupload.net;
                    
                    # --parallel=5 uploads up to 5 files at the exact same time
                    mirror -R --parallel=5 --exclude .git/ --exclude Jenkinsfile --exclude README.md ./ /htdocs;
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