var mysql = require('mysql');
module.exports = {
    conf: {
        host: 'localhost',
        user: '',
        password: '',
        database: 'session'
    },
    run: async function (sessid) {
        var connection = mysql.createConnection({
            host: this.conf.host, // 호스트 주소
            user: this.conf.user, // mysql user
            password: this.conf.password, // mysql password
            database: this.conf.database // mysql 데이터베이스
        });
        connection.connect();
        
        return new Promise(function(res, rej) {
            connection.query(`SELECT session_value FROM sessions WHERE session_key = '${sessid}';`, function(err, result, fields){
                if (err) {
                    rej(err);
                    throw err;
                }
                if(result.length == 1){
                    res(result[0]['session_value'].replace(/\\(.)/mg, "$1"));
                }else{
                    res('');
                }
            });
        });
    },
    test: function () {
        var connection = mysql.createConnection({
            host: this.conf.host, // 호스트 주소
            user: this.conf.user, // mysql user
            password: this.conf.password, // mysql password
            database: this.conf.database // mysql 데이터베이스
        });
        connection.connect();
        connection.query(
            `SELECT * FROM sessions;`,
            function (error, results, fields) {
                if (error) 
                    throw error;
                console.log(results);
            }
        );
        connection.end();
    }
}