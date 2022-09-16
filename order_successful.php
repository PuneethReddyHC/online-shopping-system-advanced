<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
        .heading a.continue:link, .heading a.continue:visited {
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: -0.015em;
        font-size: 0.75em;
        padding: 1em;
        color: #fff;
        background: #82ca9c;
        font-weight: bold;
        border-radius: 50px;
        float: right;
        text-align: right;
        -webkit-transition: all 0.25s linear;
        -moz-transition: all 0.25s linear;
        -ms-transition: all 0.25s linear;
        -o-transition: all 0.25s linear;
        transition: all 0.25s linear;
    }
    .heading a.continue:after {
        content: "\276f";
        padding: 0.5em;
        position: relative;
        right: 0;
        -webkit-transition: all 0.15s linear;
        -moz-transition: all 0.15s linear;
        -ms-transition: all 0.15s linear;
        -o-transition: all 0.15s linear;
        transition: all 0.15s linear;
    }
    .heading a.continue:hover, .heading a.continue:focus, .heading a.continue:active {
        background: #f69679;
    }
    .heading a.continue:hover:after, .heading a.continue:focus:after, .heading a.continue:active:after {
        right: -10px;
    }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Your order placed Successfully</h1> 
        <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
        <div class="heading">
            <br><br><br>
                <a href="store.php" style="float:left" class="continue">Continue Shopping</a>
                <a href="myorders.php" style="float:right" class="continue">My Orders</a>
            </div>
      </div>

    </body>
</html>