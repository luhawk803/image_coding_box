var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");

var canvasOffset = $('#canvas').offset();
var offsetX = canvasOffset.left;
var offsetY = canvasOffset.top;

var startX;
var startY;


var pi2 = Math.PI * 2;
var resizerRadius = 8;
var rr = resizerRadius * resizerRadius;
var draggingResizer = {
    x: 0,
    y: 0
};


// var imageX = 50;
// var imageY = 50;


var draggingImage = false;
imageRight = imageX + imageWidth;
imageBottom = imageY + imageHeight;

//imageWidth=100;
//imageHeight=100;



//var img = new Image();
//img.onload = function () {
 //   imageWidth = img.width;
   // imageHeight = img.height;

    //draw();
//}
//img.src = "https://dl.dropboxusercontent.com/u/139992952/stackoverflow/facesSmall.png";


function draw() {

    // clear the canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
	ctx.drawImage(img, 0, 0, img.width, img.height);
    // draw the image
   // ctx.drawImage(img, 0, 0, img.width, img.height, imageX, imageY, imageWidth, imageHeight);
    ctx.rect(imageX, imageY, imageWidth, imageHeight);

    // optionally draw the draggable anchors
    if (true) {
        drawDragAnchor(imageX, imageY);
        drawDragAnchor(imageRight, imageY);
        drawDragAnchor(imageRight, imageBottom);
        drawDragAnchor(imageX, imageBottom);
    }

    // optionally draw the connecting anchor lines
    if (true) {
        ctx.beginPath();
        ctx.moveTo(imageX, imageY);
        ctx.lineTo(imageRight, imageY);
        ctx.lineTo(imageRight, imageBottom);
        ctx.lineTo(imageX, imageBottom);
        ctx.closePath();
        ctx.stroke();
		//ctx.globalAlpha=0.7;
		//ctx.fillRect(Math.min(imageX,imageRight),Math.min(imageY,imageBottom),Math.abs(imageX-imageRight),Math.abs(imageY-imageBottom));
		ctx.fillStyle=colorarc;
    }
	var minx=Math.min(imageX,imageRight);
	var miny=Math.min(imageY,imageBottom);
	var maxx=Math.max(imageX,imageRight);
	var maxy=Math.max(imageY,imageBottom);
	var points=new Coo(minx, miny, maxx, maxy);
	
	window.sessionStorage.setItem('points', JSON.stringify(points));
	show_submit();
	//$('#position').text(points.x1+ ", " + points.y1+','+points.x2+ ", " + points.y2);
	var node=document.getElementById("position");
	node.innerHTML=points.x1+ ", " + points.y1+','+points.x2+ ", " + points.y2;
		var node1=document.getElementById("coors");
	node1.innerHTML=points.x1+ ", " + points.y1+','+points.x2+ ", " + points.y2;

}

function drawDragAnchor(x, y) {
    ctx.beginPath();
    ctx.arc(x, y, resizerRadius, 0, pi2, false);
	ctx.strokeStyle=colorarc;

	ctx.stroke();
    //ctx.closePath();
   // ctx.fill();
}

function anchorHitTest(x, y) {

    var dx, dy;

    // top-left
    dx = x - imageX;
    dy = y - imageY;
    if (dx * dx + dy * dy <= rr) {
        return (0);
    }
    // top-right
    dx = x - imageRight;
    dy = y - imageY;
    if (dx * dx + dy * dy <= rr) {
        return (1);
    }
    // bottom-right
    dx = x - imageRight;
    dy = y - imageBottom;
    if (dx * dx + dy * dy <= rr) {
        return (2);
    }
    // bottom-left
    dx = x - imageX;
    dy = y - imageBottom;
    if (dx * dx + dy * dy <= rr) {
        return (3);
    }
    return (-1);

}


function hitImage(x, y) {
	var minx=Math.min(imageX,imageRight);
	var miny=Math.min(imageY,imageBottom);
	var maxx=Math.max(imageX,imageRight);
	var maxy=Math.max(imageY,imageBottom);
    return (x > minx && x < maxx && y > miny && y <maxy);
}


function handleMouseDown(e) {
    startX = parseInt(e.clientX - offsetX);
    startY = parseInt(e.clientY - offsetY);
    draggingResizer = anchorHitTest(startX, startY);
    draggingImage = draggingResizer < 0 && hitImage(startX, startY);
}

function handleMouseUp(e) {
    draggingResizer = -1;
    draggingImage = false;
    draw();
}

function handleMouseOut(e) {
    handleMouseUp(e);
}

function handleMouseMove(e) {

    if (draggingResizer > -1) {

        mouseX = parseInt(e.clientX - offsetX);
        mouseY = parseInt(e.clientY - offsetY);

        // resize the image
        switch (draggingResizer) {
            case 0:
                //top-left
                imageX = mouseX;
                imageWidth = imageRight - mouseX;
                imageY = mouseY;
                imageHeight = imageBottom - mouseY;
                break;
            case 1:
                //top-right
                imageY = mouseY;
                imageWidth = mouseX - imageX;
                imageHeight = imageBottom - mouseY;
                break;
            case 2:
                //bottom-right
                imageWidth = mouseX - imageX;
                imageHeight = mouseY - imageY;
                break;
            case 3:
                //bottom-left
                imageX = mouseX;
                imageWidth = imageRight - mouseX;
                imageHeight = mouseY - imageY;
                break;
        }

       // if(imageWidth<15){imageWidth=15;}
       // if(imageHeight<15){imageHeight=15;}
		
        // set the image right and bottom
        imageRight = imageX + imageWidth;
        imageBottom = imageY + imageHeight;

        // redraw the image with resizing anchors
        draw();

    } else if (draggingImage) {

        imageClick = false;

        mouseX = parseInt(e.clientX - offsetX);
        mouseY = parseInt(e.clientY - offsetY);

        // move the image by the amount of the latest drag
        var dx = mouseX - startX;
        var dy = mouseY - startY;
        imageX += dx;
        imageY += dy;
        imageRight += dx;
        imageBottom += dy;
        // reset the startXY for next time
        startX = mouseX;
        startY = mouseY;
		
		if(imageX>canvas.width){imageX=canvas.width;}
		if(imageY>canvas.height){imageY=canvas.height;}
		if(imageX<0){imageX=0;}
		if(imageY<0){imageY=0;}
		if(imageRight>canvas.width){imageRight=canvas.width;}
		if(imageBottom>canvas.height){imageBottom=canvas.height;}
		if(imageRight<0){imageRight=0;}
		if(imageBottom<0){imageBottom=0;}
  
		
        // redraw the image with border
        draw();

    }


}


$("#canvas").mousedown(function (e) {
	if (!hasRec)
		{
		imageX=parseInt(e.clientX - offsetX);
		imageY=parseInt(e.clientY - offsetY);
		imageWidth=0;
		imageHeight=0;
		imageRight = imageX + imageWidth;
		imageBottom = imageY + imageHeight;
		hasRec=true;	
		}
		handleMouseDown(e);
	
});

$("#canvas").mousemove(function (e) {
    handleMouseMove(e);
});
$("#canvas").mouseup(function (e) {
    handleMouseUp(e);
});
$("#canvas").mouseout(function (e) {
    handleMouseOut(e);
});
if (window.sessionStorage.getItem('points')!=null)
	{
	window.onmousemove=gmousemoved;
	}
function gmousemoved()
	{
	if (codebefore ||window.sessionStorage.getItem('points')!=null){
		var s= $.parseJSON(window.sessionStorage.getItem('points'));
		if (s.x1+s.y1+s.x2+s.y2!=0){
		imageX=s.x1;
		imageY=s.y1;
		imageRight=s.x2;
		imageBottom=s.y2;
		imageWidth=Math.abs(imageX,imageRight);
		imageHeight=Math.abs(imageY,imageBottom);
		hasRec=true;
		draw();	
		}
		}
	}