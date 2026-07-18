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
                echo 'Installing LFTP and deploying with stable connection settings...'
                sh '''
                    apk add --no-cache lftp
                    
                    lftp -c "
                    set ftp:passive-mode true;
                    set ftp:ssl-allow false;
                    
                    # STABLE CONNECTION SETTINGS 👇
                    set net:timeout 30;
                    set net:max-retries 5;
                    set net:reconnect-interval-base 5;
                    
                    open -u 'if0_42438585','C5u4b3lKP8D5Zp' ftpupload.net;
                    
                    # --parallel=2 is safe and avoids firewall rate limits
                    mirror -R --parallel=2 --exclude .git/ --exclude Jenkinsfile --exclude README.md ./ /htdocs;
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