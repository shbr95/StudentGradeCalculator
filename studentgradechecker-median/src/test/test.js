var expect  = require('chai').expect;
var functions = require('../functions');
var req = require('../app');
var req = require('request');
var assert = require('assert')


//sort Array Test
it('Test sort array', function(done) {
    var input_text = "module1,87newlinemodule2,48newlinemodule3,90"
    var actual = functions.sortArray(input_text)
  
    var expected = [{module: 'module2', mark: '48'}, {module: 'module1', mark: '87'}, {module: 'module3', mark: '90'}]

    expect(actual).to.deep.equal(expected);
    done();
});


