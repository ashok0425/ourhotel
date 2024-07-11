<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PAGE NOT FOUND|NSN HOTELS</title>
    
    <style>

 body {
	 margin: 0px;
	 height: 100vh;
	 width: 100vw;
	 overflow: hidden;
	 background-repeat: no-repeat;
	 background-size: 100%;
	/*Vector by Vecteezy www.vecteezy.com*/
	 background: radial-gradient(white, #cccdd1);
}
 .container {
	 display: flex;
	 height: 100%;
	 width: 100%;
	 align-items: center;
	 justify-content: center;
}
 .sign-wrapper {
	 width: 400px;
	 height: 100%;
}
 .sign {
	 margin: 150px;
	 background: radial-gradient(rgb(29,71,131), rgb(14, 62, 129));
	 height: 150px;
	 width: 150px;
	 display: flex;
	 align-items: center;
	 justify-content: center;
	 border-radius: 8px;
	 border: 4px solid rgb(29,71,131);
	 box-shadow: inset 0px 0px 0px 4px #949292;
	 transform: rotate(45deg);
	 position: relative;
	 z-index: 1;
     color: #fff!important;
}
 .sign::before {
	 position: absolute;
	 z-index: -1;
	 content: &#34;
	&#34;
	;
	 background: linear-gradient(to right, #8c8c8c, #afafaf 20%, #8c8c8c 80%);
	 height: 200px;
	 width: 10px;
	 transform-origin: top;
	 transform: rotate(-45deg);
	 top: 150px;
	 left: 145px;
}
 .sign .message {
	 transform: rotate(-45deg);
	 color: #fff;
	 font-weight: bold;
	 font-size: 70px;
     animation: animation 1.5s ease-in-out infinite;

}
 .sign .message::before, .sign .message::after {
	 position: absolute;
	 content: &#34;
	&#34;
	 height: 6px;
	 width: 6px;
	 background: linear-gradient(to right, #ccc, #afafaf);
	 left: 66px;
	 border-radius: 50%;
	 top: -50px;
}
 .sign .message::after {
	 top: 130px;
}
 .sign .redirect {
	 position: absolute;
	 top: 170px;
	 left: 80px;
	 height: 40px;
	 line-height: 40px;
	 text-align: center;
	 width: 150px;
	 background: radial-gradient(#5aced5, #5aced5);
	 transform-origin: top;
	 transform: rotate(-48deg);
	 transform-style: preserve-3d;
	 backface-visibility: hidden;
	 font-family: &#34;
	Montserrat&#34;
	, sans-serif;
	 padding: 10px;
	 box-shadow: inset 0px 0px 0px 3px white;
	 border-radius: 5px;
	 border: 5px solid #5aced5;
}
 .sign .redirect a {
	 color: white;
	 text-decoration: none;
	 text-transform: uppercase;
}
 .sign .redirect:before {
	 position: absolute;
	 content: &#34;
	&#34;
	;
	 height: 6px;
	 width: 6px;
	 background: linear-gradient(to right, #ccc, #afafaf);
	 border-radius: 50%;
	 left: 81px;
}
 .info {
	 width: 350px;
}
 .info h1 {
	 color: rgb(29,71,131);
	 font-family: &#34;
	Montserrat&#34;
	, sans-serif;
	 font-weight: bold;
}
 .info p {
	 font-family: &#34;
	Montserrat&#34;
	, sans-serif;
	 color: #1d1d1d;
	 font-size: 16px;
}
@keyframes animation{
0%{
transform: translateY(0)
}
25%{
transform: translateY(10px)
    
}

50%{
transform: translateY(20px)
    
}

75%{
transform: translateY(10px)
    
}

100%{
transform: translateY(0px)
    
}
}
    </style>
</head>
<body>
    <div class="container">
        <div class="sign-wrapper">
          <div class="sign">
            <div class="message">
              404
            </div>
            <div class="pole"></div>
            <div class="redirect">
              <a href="{{route('home')}}">
                back to home
              </a>
            </div>
          </div>
        </div>
        <div class="info">
          <h1>
            Oops,  PAGE NOT FOUND
          </h1>
          <p>
            The page you are looking for couldn't found in this server.Probably it may be moved or deleted.
          </p>
        </div>
      </div>
</body>
</html>