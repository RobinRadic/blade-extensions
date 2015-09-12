var tsd = require('./typescript_deferred');

module.exports = {
    resolved: function(value) {
        return tsd.when(value);
    },

    rejected: function(reason) {
        return tsd.create().reject(reason).promise;
    },

    deferred: function() {
        return tsd.create();
    }
};
