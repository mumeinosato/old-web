<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <META charset="UTF-8">
  <title></title>
<script>
  function TReversi(can,tx,button){
    'use strict';
    this.wh=320;
    this.canvas=can;
    this.cx=this.canvas.getContext('2d');
    this.canvas.style.width="70vmin";
    this.canvas.style.height="70vmin";
    this.canvas.setAttribute("width",this.wh+"px");
    this.canvas.setAttribute("height",this.wh+"px");
    this.textarea=tx;
    this.ai=[
      {x:0,y:0},{x:0,y:7},{x:7,y:7},{x:7,y:0},
      {x:2,y:2},{x:2,y:5},{x:5,y:5},{x:5,y:2},
      {x:2,y:0},{x:0,y:2},{x:0,y:5},{x:2,y:7},
      {x:5,y:7},{x:7,y:5},{x:7,y:2},{x:5,y:0},
      {x:3,y:1},{x:1,y:3},{x:1,y:4},{x:3,y:6},
      {x:4,y:6},{x:6,y:4},{x:6,y:3},{x:4,y:1},
      {x:3,y:0},{x:0,y:3},{x:0,y:4},{x:3,y:7},
      {x:4,y:7},{x:7,y:4},{x:7,y:3},{x:4,y:0},
      {x:3,y:2},{x:2,y:3},{x:2,y:4},{x:3,y:5},
      {x:4,y:5},{x:5,y:4},{x:5,y:3},{x:4,y:2},
      {x:2,y:1},{x:1,y:2},{x:1,y:5},{x:2,y:6},
      {x:5,y:6},{x:6,y:5},{x:6,y:2},{x:5,y:1},
      {x:1,y:0},{x:0,y:1},{x:0,y:6},{x:1,y:7},
      {x:6,y:7},{x:7,y:6},{x:7,y:1},{x:6,y:0},
      {x:1,y:1},{x:1,y:6},{x:6,y:6},{x:6,y:1},
      {x:3,y:3},{x:3,y:4},{x:4,y:4},{x:4,y:3}
    ];
    this.board=[];
    this.pcuser="";//"","pc","user"
    this.user_iro=1;//1:white 2:black
    this.pc_iro=2;//1:white 2:black
    this.winResize=function(event){
    }
    //開始
    this.start=function(){
      this.textarea.innerHTML="";
      let x,y;
      for(x=0;x<8;x++){
        this.board[x]=[];
        for(y=0;y<8;y++){
          this.board[x][y]=0;
        }
      }
      this.board[3][3]=1;
      this.board[4][4]=2;
      this.board[3][4]=2;
      this.board[4][3]=1;
      if(Math.random()>0.5){
        this.pcuser="pc";
      }else{
        this.pcuser="user";
      }
      if(Math.random()>0.5){
        this.user_iro=1;
        this.pc_iro=2;
      }else{
        this.user_iro=2;
        this.pc_iro=1;
      }
      this.draw();
      this.textout_count();
      this.textout();
      if(this.pcuser=="pc"){
        setTimeout(this.calculate.bind(this),1000);
      }
    }
    //描画
    this.draw=function(){
      this.cx.fillStyle="#3C3";
      this.cx.fillRect(0,0,this.wh,this.wh);
      let x,y;
      this.cx.strokeStyle="#FFF";
      this.cx.lineWidth=4;
      for(x=0;x<8;x++){
        this.cx.beginPath();
        this.cx.moveTo(this.wh/8*x,0);
        this.cx.lineTo(this.wh/8*x,this.wh);
        this.cx.stroke();
      }
      for(y=0;y<8;y++){
        this.cx.beginPath();
        this.cx.moveTo(0,this.wh/8*y);
        this.cx.lineTo(this.wh,this.wh/8*y);
        this.cx.stroke();
      }
      this.lineWidth=2;
      for(x=0;x<8;x++){
        for(y=0;y<8;y++){
          if(this.board[x][y]==1){
            this.cx.strokeStyle="#000";
            this.cx.fillStyle="#FFF";
            this.cx.beginPath();
            this.cx.arc(this.wh/8*(x+0.5),this.wh/8*(y+0.5),this.wh/8/2*0.7,0,Math.PI*2,false);
            this.cx.fill();
            this.cx.stroke();
          }
          if(this.board[x][y]==2){
            this.cx.strokeStyle="#FFF";
            this.cx.fillStyle="#000";
            this.cx.beginPath();
            this.cx.arc(this.wh/8*(x+0.5),this.wh/8*(y+0.5),this.wh/8/2*0.7,0,Math.PI*2,false);
            this.cx.fill();
            this.cx.stroke();
          }
        }
      }
    }
    //文字出力(順番)
    this.textout=function(){
      let ucol="",pcol="";
      if(this.user_iro==1){ucol="白";pcol="黒";}else{ucol="黒";pcol="白";}
      if(this.pcuser=="user"){this.textarea.innerHTML=this.textarea.innerHTML+'\nあなたの番('+ucol+')';}
      if(this.pcuser=="pc"){this.textarea.innerHTML+='\nＰＣの番('+pcol+')';}
      this.textarea.scrollTop=this.textarea.scrollHeight;
    }
    //文字列出力(駒の数)
    this.textout_count=function(){
      let ucol="",pcol="";
      if(this.user_iro==1){ucol="白";pcol="黒";}else{ucol="黒";pcol="白";}
      let x, y;
      let pc_count=0, user_count=0;
      for(x=0;x<8;x++){
        for(y=0;y<8;y++){
          if(this.board[x][y]==this.user_iro){
            user_count++;
          }else if(this.board[x][y]==this.pc_iro){
            pc_count++;
          }
        }
      }
      this.textarea.innerHTML+='\nあなた('+ucol+'):'+user_count+'  PC('+pcol+'):'+pc_count;
      this.textarea.scrollTop=this.textarea.scrollHeight;
      if(this.cannot_pc_user()){
        this.pcuser="";
        this.textarea.innerHTML+='\nゲーム終了';
        this.textarea.scrollTop=this.textarea.scrollHeight;
      }
    }
    this.canputpiece=function(x,y,okuiro,dx,dy){
      let kaesuiro=1;
      if(okuiro==1){kaesuiro=2;}
      let flag=0;
      let spx=x+dx;
      let spy=y+dy;
      while(spx>=0 && spx<=7 && spy>=0 && spy<=7){
        if(this.board[spx][spy]==0){
          break;
        }else if(this.board[spx][spy]==kaesuiro){
          flag=1;
        }else if(this.board[spx][spy]==okuiro){
          if(flag==1){flag=2;}
          break;
        }
        spx+=dx;
        spy+=dy;
      }
      if(flag==2){
        return true;
      }else{
        return false;
      }
    }
    this.canputpieces=function(x,y,okuiro){
      let flag=false;
      if(this.canputpiece(x,y,okuiro, 0,-1)){flag=true;}
      if(this.canputpiece(x,y,okuiro,-1,-1)){flag=true;}
      if(this.canputpiece(x,y,okuiro,-1, 0)){flag=true;}
      if(this.canputpiece(x,y,okuiro,-1, 1)){flag=true;}
      if(this.canputpiece(x,y,okuiro, 0, 1)){flag=true;}
      if(this.canputpiece(x,y,okuiro, 1, 1)){flag=true;}
      if(this.canputpiece(x,y,okuiro, 1, 0)){flag=true;}
      if(this.canputpiece(x,y,okuiro, 1,-1)){flag=true;}
      return flag;
    }
    this.reversepiece=function(x,y,okuiro,dx,dy){
      let kaesuiro=1;
      if(okuiro==1){kaesuiro=2;}
      let res=this.canputpiece(x,y,okuiro,dx,dy);
      if(res){
        let spx=x+dx;
        let spy=y+dy;
        while(this.board[spx][spy]==kaesuiro&&spx>=0&&spx<=7&&spy>=0&&spy<=7){
          this.board[spx][spy]=okuiro;
          spx+=dx;
          spy+=dy;
        }
      }
    }
    this.reversepieces=function(x,y,okuiro){
      let flag=false;
      if(this.reversepiece(x,y,okuiro, 0,-1)){flag=true;}
      if(this.reversepiece(x,y,okuiro,-1,-1)){flag=true;}
      if(this.reversepiece(x,y,okuiro,-1, 0)){flag=true;}
      if(this.reversepiece(x,y,okuiro,-1, 1)){flag=true;}
      if(this.reversepiece(x,y,okuiro, 0, 1)){flag=true;}
      if(this.reversepiece(x,y,okuiro, 1, 1)){flag=true;}
      if(this.reversepiece(x,y,okuiro, 1, 0)){flag=true;}
      if(this.reversepiece(x,y,okuiro, 1,-1)){flag=true;}
      return flag;
    }
    //交代
    this.orderchange=function(){
      if(this.pcuser=="user"){
        this.pcuser="pc";
      }else if(this.pcuser="pc"){
        this.pcuser="user";
      }
      this.textout_count();
      this.textout();
      if(this.pcuser=="pc"){
        setTimeout(this.calculate.bind(this),1000);
      }
    }
    //次の手を探す
    this.calculate=function(){
      if(this.pcuser!="pc"){return false;}
      let dx=-1;
      let dy=-1;
      let i;
      for(i=0;i<this.ai.length;i++){
        if(this.board[this.ai[i].x][this.ai[i].y]==0){
          if(this.canputpieces(this.ai[i].x,this.ai[i].y,this.pc_iro)){
            dx=this.ai[i].x;
            dy=this.ai[i].y;
            break;
          }
        }
      }
      if(dx==-1){
        this.textarea.innerHTML+='\nＰＣ：駒を置けないのでパス';
        this.textarea.scrollTop=this.textarea.scrollHeight;
      }else{
        this.board[dx][dy]=this.pc_iro;
        this.reversepieces(dx,dy,this.pc_iro);
      }
      this.orderchange();
      this.draw();
    }
    //ユーザーが駒を置けない(true)
    this.cannot_user=function(){
      let x,y;
      let flag=true;
      for(x=0;x<8;x++){
        for(y=0;y<8;y++){
          if(this.board[x][y]==0){
            if(this.canputpieces(x,y,this.user_iro)){
              flag=false;
              break;
            }
          }
        }
      }
      return flag;
    }
    //PCが駒を置けない(true)
    this.cannot_pc=function(){
      let x,y;
      let flag=true;
      for(x=0;x<8;x++){
        for(y=0;y<8;y++){
          if(this.board[x][y]==0){
            if(this.canputpieces(x,y,this.pc_iro)){
              flag=false;
              break;
            }
          }
        }
      }
      return flag;
    }
    //PCもユーザーも駒を置けない(true)
    this.cannot_pc_user=function(){
      let flag=true;
      let x,y;
      for(x=0;x<8;x++){
        for(y=0;y<8;y++){
          if(this.board[x][y]==0){
            flag=false;
            break;
          }
        }
      }
      if(flag==false){
        if(this.cannot_user()&&this.cannot_pc()){
          flag=true;
        }
      }
      return flag;
    }
    this.click=function(event){
      if(this.pcuser=="user"){
        let stl = window.getComputedStyle(this.canvas);
        let wh=parseFloat(stl.width)/8;
        let x=Math.floor((event.clientX-event.target.getBoundingClientRect().left)/wh);
        let y=Math.floor((event.clientY-event.target.getBoundingClientRect().top)/wh);
        if(x>=0&&x<=7&&y>=0&&y<=7){
          if(this.board[x][y]==0 && this.canputpieces(x,y,this.user_iro)){
            this.board[x][y]=this.user_iro;
            this.reversepieces(x,y,this.user_iro);
            this.orderchange();
            this.draw();
            setTimeout(this.calculate.bind(this),1000);
          }else{
            this.textarea.innerHTML+='\n指定した場所には置けません';
            this.textarea.scrollTop=this.textarea.scrollHeight;
          }
        }
      }
    }
    button.addEventListener("click",this.start.bind(this));
    this.start();
    this.canvas.addEventListener("click",this.click.bind(this));
  }


  var reversi;
  window.addEventListener('DOMContentLoaded',function(event){
    reversi=new TReversi(
      document.getElementById("reversi_canvas"),  //描画キャンバス
      document.getElementById("reversi_textarea"),//状態を表示するtextarea
      document.getElementById("reversi_start")    //スタートボタン
    );
    window.addEventListener("resize",reversi.winResize);
  });
</script>
</head>
<body>
<button id="reversi_start">開始</button><br>
<canvas id="reversi_canvas"></canvas>
<textarea id="reversi_textarea" rows="8" style="width:100%;"></textarea>
<br>
<br>
</body>
</html>