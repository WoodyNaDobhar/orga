import{d as l,s as t,v as h,M as u,o as p,l as g,u as m}from"./main-BsKWZMZP.js";import{g as o,_}from"./colors-CRGuWm5e.js";const f=l({__name:"ReportPieChart",props:{width:{},height:{}},setup(n){const e=n,a=t(()=>h().colorScheme),s=t(()=>u().darkMode),d=[15,10,65],r=()=>[o("pending",.9),o("warning",.9),o("primary",.9)],i=t(()=>({labels:["Yellow","Dark"],datasets:[{data:d,backgroundColor:a.value?r():"",hoverBackgroundColor:a.value?r():"",borderWidth:5,borderColor:s.value?o("darkmode.700"):o("white")}]})),c=t(()=>({maintainAspectRatio:!1,plugins:{legend:{display:!1}}}));return(k,w)=>(p(),g(m(_),{type:"pie",width:e.width,height:e.height,data:i.value,options:c.value},null,8,["width","height","data","options"]))}}),b=l({__name:"ReportDonutChart1",props:{width:{},height:{}},setup(n){const e=n,a=t(()=>h().colorScheme),s=t(()=>u().darkMode),d=[15,10,65],r=()=>[o("pending",.9),o("warning",.9),o("primary",.9)],i=t(()=>({labels:["Yellow","Dark"],datasets:[{data:d,backgroundColor:a.value?r():"",hoverBackgroundColor:a.value?r():"",borderWidth:2,borderColor:s.value?o("darkmode.700"):o("white")}]})),c=t(()=>({maintainAspectRatio:!1,plugins:{legend:{display:!1}},cutout:"83%"}));return(k,w)=>(p(),g(m(_),{type:"doughnut",width:e.width,height:e.height,data:i.value,options:c.value},null,8,["width","height","data","options"]))}});export{f as _,b as a};
