

<style>
    .ribbon{
  font-size:20px;
  position:relative;
  display:inline-block;
  text-align:center;
  animation: mymove ease-in 2.2s infinite;
}
.ribbon .text{
  display:inline-block;
  padding:0.5em 1em;
  min-width:20em;
  line-height:1.2em;
  background: #ee2e24 !important;
  position:relative;
  color:#fff!important;
}
.ribbon:after,.ribbon:before,
.text:before,.text:after,
.bold:before{
  content:'';
  position:absolute;
  border-style:solid;
}
.ribbon:before{
  top:0.3em; left:0.2em;
  width:100%; height:100%;
  border:none;
  background:#EBECED;
  z-index:-2;
}
.ribbon  .text:before{
  bottom:100%; left:0;
  border-width: .5em .7em 0 0;
  border-color: transparent #ee2e24  transparent transparent;
}
.ribbon  .text:after{
  top:100%; right:0;
  border-width: .5em 2em 0 0;
  border-color: #ee2e24 transparent transparent transparent;
}
.ribbon:after, .bold:before{
  top:0.5em;right:-2em;
  border-width: 1.1em 1em 1.1em 3em;
  border-color: #ee2e24 transparent #ee2e24 #ee2e24;
  z-index:-1;
}
.ribbon .bold:before{
  border-color: #EBECED transparent #EBECED #EBECED;
  top:0.7em;
  right:-2.3em;
}
@keyframes mymove {

  0%   {transform: scale(.7)}
  25%  {transform: scale(.8)}
  50%  {transform: scale(.84)}
  75%  {transform: scale(.84)}
  100% {transform: scale(.7)}
}
.text{
    font-size: 16px;
}
</style>
<p class="ribbon">
    <span class="text"><strong class="bold text-white">Special Offer:</strong>  
        Pay now and get 10% immediate cashback</span>
  </p>