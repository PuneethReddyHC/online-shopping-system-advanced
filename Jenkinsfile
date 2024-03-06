pipeline {
    agent any
 
    environment {
        staging_server = "54.80.188.48"
        ssh_key = credentials('pemkey')
    }
 
    stages {
        stage('Remote server login') {
            steps {
                script {
                    sh '''
                        ssh -i $HOME ${ssh_key} root@${staging_server} -o StrictHostKeyChecking=no
                        echo "welcome"
                    '''
                }
            }
        }
        stage('Deploy to Remote') {
            steps {
                script {
                    sh '''
                        for fileName in `find ${WORKSPACE} -type f -mmin -10 | grep -v ".git" | grep -v "Jenkinsfile"`
                        do
                            fil=$(echo ${fileName} | sed 's/'"${JOB_NAME}"'/ /' | awk {'print $2'})
                            scp -r ${WORKSPACE}/${fil} root@${staging_server}:/var/www/html/ecomdemo${fil}
                        done
                    '''
                }
            }
        }
    }
}
