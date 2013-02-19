var model = require('../model');
var keitai = model.keitai;

exports.index = function(req, res){
  keitai.find({'number':'1'},{'number':0}, { limit :1 }, function(err, items){
    console.log(items);
      res.render('index', { title: 'ry List', items: items })
  });
};

exports.form = function(req, res){
  res.render('form', { title: 'New Entry' })
};

