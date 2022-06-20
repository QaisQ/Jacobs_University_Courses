const { expect } = require('chai');
const chai = require('chai');
const { JSDOM } = require('jsdom');

// 
const request = require("request");
const baseUrl = "http://localhost/";
// 
chai.use(require('chai-dom'));
require('jsdom-global')();

describe('index.html', () => {

  beforeEach((done) => {
   JSDOM.fromFile('index.html')
   .then((dom) => {
     global.document = dom.window.document
   })
 .then(done, done);
 })


//  Note:
//  Each Test case breifly checks if texts are rendered well in the front webpage where we use for indexing purposes
//  Other test cases about backend or other parts are included and documented in the documenation part.

describe("Website Title", () => {
 it("Welcome to Corona Archive'", () => {
  let element = document.querySelector('h3')
  expect(element).to.have.text("Welcome to Corona Archive")
 })
})

describe("Navigation of each participant description", () => {
  it("Displays: WHICH ONE ARE YOU?", () => {
   let element = document.querySelector('h2')
   expect(element).to.have.text("WHICH ONE ARE YOU?")
  })
 })

 describe("Content description of Visitor/Citizen", () => {
  it("Displays: info about what citizens use this website for", () => {
   let element = document.querySelector('h4')
   expect(element).to.have.text("Citizens or visitors will use the web service to indicate whether they have entered a particular place and when they have done so.")
  })
 })

 describe("Disclaimer Title Below", () => {
  it("Displays the Disclaimer Title below the webpage", () => {
   let element = document.querySelector('h1')
   expect(element).to.have.text(" Disclaimer ")
  })
 })

 describe("Get Started Button", () => {
  it("Displays the text on the button that redirects below", () => {
   let element = document.querySelector('a')
   expect(element).to.have.text("GET STARTED")
  })
 })

})


// checking routes 
// the tests checks the routes of signup and login
// functionalities of all 4 users
describe('check routes', function() {
  it('checks visitor signup page', function(done) {
      request.get({ url: baseUrl + '/Visitor-Registration-Login/sign-up.php' },
          function(error, res, body) {
              expect(res.statusCode).to.equal(200);
              expect(res).to.have.property('body');
              expect(res.body).to.contain('Sign Up');
              done();
          });
  });

  it('checks visitor login page', function(done) {
    request.get({ url: baseUrl + '/Visitor-Registration-Login/login.php' },
        function(error, res, body) {
            expect(res.statusCode).to.equal(200);
            expect(res).to.have.property('body');
            expect(res.body).to.contain('Login');
            done();
        });
});

it('checks place owner signup page', function(done) {
  request.get({ url: baseUrl + '/Place-Registration-Login/sign-up.php' },
      function(error, res, body) {
          expect(res.statusCode).to.equal(200);
          expect(res).to.have.property('body');
          expect(res.body).to.contain('Sign Up');
          done();
      });
});


it('checks place owner login page', function(done) {
  request.get({ url: baseUrl + '/Place-Registration-Login/login.php' },
      function(error, res, body) {
          expect(res.statusCode).to.equal(200);
          expect(res).to.have.property('body');
          expect(res.body).to.contain('Login');
          done();
      });
});

it('checks Hopsital signup page', function(done) {
  request.get({ url: baseUrl + '/Hospital-Registration-Login/sign-up.php' },
      function(error, res, body) {
          expect(res.statusCode).to.equal(200);
          expect(res).to.have.property('body');
          expect(res.body).to.contain('Register Hospital');
          done();
      });
});

it('checks Hopsital login page', function(done) {
  request.get({ url: baseUrl + '/Hospital-Registration-Login/login.php' },
      function(error, res, body) {
          expect(res.statusCode).to.equal(200);
          expect(res).to.have.property('body');
          expect(res.body).to.contain('Login');
          done();
      });
});

it('checks Agency login page', function(done) {
  request.get({ url: baseUrl + '/Agency-Registration-Login/login.php' },
      function(error, res, body) {
          expect(res.statusCode).to.equal(200);
          expect(res).to.have.property('body');
          expect(res.body).to.contain('Login');
          done();
      });
});

});