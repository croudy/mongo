var mongoose = require('mongoose');
var db = mongoose.connect('mongodb://localhost/ban');

var keitai = new mongoose.Schema({
      number : String 
    , mail   : String
    , name   : String
    , date   : String
    , id     : String
    , body   : String
});


exports.keitai = db.model('keitai', keitai);
