<template>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" ng-show="authenticated" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         <!-- <a class="navbar-brand" href="#">Awesome<strong>Power</strong></a>-->
          <a  rel="home" title="AwesomePower"><img width="100px" height="50px" src="static/images/RPlogo4.png"/></a>
          
        </div>

        <div id="navbar" class="navbar-collapse collapse">
 
          <ul class="nav navbar-nav navbar-right">
            <!-- <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li> -->
            

            <li>
<a  class="dropdown-toggle" style="background-color: #CED3F5;" data-toggle="dropdown" ng-show="authenticated" role="button" aria-haspopup="true" aria-expanded="false">Options   <span class="caret"></span></a>
              <ul class="dropdown-menu">
                
                <li><a href="#dashboard">Dashboard</a></li>
 <!--               <li><a href="#message">Messages</a></li> -->
 
 
              <li ng-show="isadmin"><a href="#usermgmt" ng-show="isadmin">User Management</a></li>
               <!--  <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li> -->
              </ul>
            </li>

            <li class="active">
            
              <a  class="dropdown-toggle" data-toggle="dropdown" ng-show="authenticated" role="button" aria-haspopup="true" aria-expanded="false">Welcome <strong>{{name}}</strong>  <span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li><a ng-click="myprofile();">My Profile</a></li>
              <li><a href="#logout">Logout</a></li>
                
               <!--  <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li> -->
              </ul>
            </li>
          </ul>
          <!-- <ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar/">Default</a></li>
            <li><a href="../navbar-static-top/">Static top</a></li>
            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
          </ul> -->
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</template>

<script>
  export default {
    data() {
      return {
        dialogVisible: false,
        name:'name'
      }
    },
    methods: {
      handleClose(done) {
        this.$confirm('确认关闭？')
            .then(_ => {
              done();
            })
            .catch(_ => {
            });
      }
    }
  }
</script>

