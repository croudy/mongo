
/*
 * GET home page.
 */

var model = require('../model');
var ejs = require('ejs');
var fs = require('fs');
var keitai = model.keitai;
var qs=require('querystring');
var forms =  ""
var keyword = { 
  "number" : {"type" : "equal"},
  "mail"   : {"type" : "like"},
  "name"   : {"type" : "like"},
  "date"   : {"type" : "like"},
  "id"     : {"type" : "like"},
  "body"   : {"type" : "like"}
} ;

exports.index = function(req, res){
  var where = new Object();
  for(var i in keyword ){
    if( req.query[i] == "" || req.query[i] == undefined ){
      req.query[i] = "";
    }
    else{
      if( keyword[i]["type"] == "like" ){
        var regex = new RegExp(req.query[i]);
        where[i] = regex; 
      }
      else{
        where[i] = req.query[i]; 
      }
    }
  }
  console.log('req.query');
  console.log(req.query);
  console.log('where');
  console.log(where);
  keitai.find( where ,{}, { limit:10000, sort:{"_id":1} }, function(err, items){
  console.log('find where');
    console.log(where);
    console.log(items);
    res.render('index', { title: '検索', query: req.query, items: items })
  });
};
