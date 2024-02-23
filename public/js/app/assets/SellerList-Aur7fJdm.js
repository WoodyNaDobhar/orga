import{d as S,r as b,f as w,g as o,h as t,w as s,u as e,F as v,o as f,i as r,T as c,_ as l,m as D,B as T,j as F,a as E,l as I,t as u,q as g,n as k,s as A,D as y}from"./main-CeS48KJa.js";import{_}from"./Button.vue_vue_type_script_setup_true_lang-qNMd5tCb.js";import{P as n}from"./index-pRnO0Icy.js";import{_ as C}from"./FormSelect.vue_vue_type_script_setup_true_lang-rccilgeM.js";import{T as a}from"./index-fLICxV2N.js";const B=o("h2",{class:"mt-10 text-lg font-medium intro-y"},"Seller List",-1),P={class:"grid grid-cols-12 gap-6 mt-5"},R={class:"flex flex-wrap items-center col-span-12 mt-2 intro-y xl:flex-nowrap"},N={class:"flex items-center justify-center w-5 h-5"},$=o("div",{class:"hidden mx-auto xl:block text-slate-500"}," Showing 1 to 10 of 150 entries ",-1),j={class:"flex items-center w-full mt-3 xl:w-auto xl:mt-0"},M={class:"relative w-56 text-slate-500"},O=o("option",null,"Status",-1),q=o("option",null,"Active",-1),U=o("option",null,"Inactive",-1),V={class:"col-span-12 overflow-auto intro-y 2xl:overflow-visible"},z={class:"flex items-center"},G={class:"w-9 h-9 image-fit zoom-in"},H={class:"ml-4"},X={href:"",class:"font-medium whitespace-nowrap"},J={class:"text-slate-500 text-xs whitespace-nowrap mt-0.5"},K={class:"flex items-center justify-center underline decoration-dotted",href:"#"},Q={class:"flex items-center justify-center"},W={class:"flex items-center mr-3",href:"#"},Y={class:"flex flex-wrap items-center col-span-12 intro-y sm:flex-row sm:flex-nowrap"},Z=o("option",null,"10",-1),ee=o("option",null,"25",-1),te=o("option",null,"35",-1),se=o("option",null,"50",-1),oe={class:"p-5 text-center"},re=o("div",{class:"mt-5 text-3xl"},"Are you sure?",-1),ae=o("div",{class:"mt-2 text-slate-500"},[r(" Do you really want to delete these records? "),o("br"),r(" This process cannot be undone. ")],-1),le={class:"px-5 pb-8 text-center"},pe=S({__name:"SellerList",setup(ne){const m=b(!1),p=h=>{m.value=h},x=b(null);return(h,i)=>(f(),w(v,null,[B,o("div",P,[o("div",R,[t(e(_),{variant:"primary",class:"mr-2 shadow-md"},{default:s(()=>[r(" Add New Seller ")]),_:1}),t(e(c),null,{default:s(()=>[t(e(c).Button,{as:e(_),class:"px-2 !box"},{default:s(()=>[o("span",N,[t(e(l),{icon:"Plus",class:"w-4 h-4"})])]),_:1},8,["as"]),t(e(c).Items,{class:"w-40"},{default:s(()=>[t(e(c).Item,null,{default:s(()=>[t(e(l),{icon:"Printer",class:"w-4 h-4 mr-2"}),r(" Print ")]),_:1}),t(e(c).Item,null,{default:s(()=>[t(e(l),{icon:"FileText",class:"w-4 h-4 mr-2"}),r(" Export to Excel ")]),_:1}),t(e(c).Item,null,{default:s(()=>[t(e(l),{icon:"FileText",class:"w-4 h-4 mr-2"}),r(" Export to PDF ")]),_:1})]),_:1})]),_:1}),$,o("div",j,[o("div",M,[t(e(D),{type:"text",class:"w-56 pr-10 !box",placeholder:"Search..."}),t(e(l),{icon:"Search",class:"absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3"})]),t(e(C),{class:"w-56 ml-2 xl:w-auto !box"},{default:s(()=>[O,q,U]),_:1})])]),o("div",V,[t(e(a),{class:"border-spacing-y-[10px] border-separate -mt-2"},{default:s(()=>[t(e(a).Thead,null,{default:s(()=>[t(e(a).Tr,null,{default:s(()=>[t(e(a).Th,{class:"border-b-0 whitespace-nowrap"},{default:s(()=>[t(e(T).Input,{type:"checkbox"})]),_:1}),t(e(a).Th,{class:"border-b-0 whitespace-nowrap"},{default:s(()=>[r(" SELLER ")]),_:1}),t(e(a).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" STORE ")]),_:1}),t(e(a).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" GENDER ")]),_:1}),t(e(a).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" STATUS ")]),_:1}),t(e(a).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" TOTAL PRODUCTS ")]),_:1}),t(e(a).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" ACTIONS ")]),_:1})]),_:1})]),_:1}),t(e(a).Tbody,null,{default:s(()=>[(f(!0),w(v,null,F(e(g).take(e(A),9),(d,L)=>(f(),E(e(a).Tr,{key:L,class:"intro-x"},{default:s(()=>[t(e(a).Td,{class:"box w-10 whitespace-nowrap rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[t(e(T).Input,{type:"checkbox"})]),_:1}),t(e(a).Td,{class:"box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 !py-3.5 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[o("div",z,[o("div",G,[t(e(I),{as:"img",alt:"Midone - HTML Admin Template",class:"border-white rounded-lg shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]",src:d.images[0],content:`Uploaded at ${d.dates[0]}`},null,8,["src","content"])]),o("div",H,[o("a",X,u(d.users[0].name),1),o("div",J,u(d.users[0].email),1)])])]),_:2},1024),t(e(a).Td,{class:"box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[o("a",K,u(["Themeforest","Codecanyon","Graphicriver"][e(g).random(0,2)]),1)]),_:1}),t(e(a).Td,{class:"box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[r(u(d.users[0].gender),1)]),_:2},1024),t(e(a).Td,{class:"box w-40 whitespace-nowrap rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[o("div",{class:k(["flex items-center justify-center",{"text-success":d.trueFalse[0]},{"text-danger":!d.trueFalse[0]}])},[t(e(l),{icon:"CheckSquare",class:"w-4 h-4 mr-2"}),r(" "+u(d.trueFalse[0]?"Active":"Inactive"),1)],2)]),_:2},1024),t(e(a).Td,{class:"box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[r(u(d.totals[0])+" Items ",1)]),_:2},1024),t(e(a).Td,{class:k(["box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600","before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400"])},{default:s(()=>[o("div",Q,[o("a",W,[t(e(l),{icon:"CheckSquare",class:"w-4 h-4 mr-1"}),r(" Edit ")]),o("a",{class:"flex items-center text-danger",href:"#",onClick:i[0]||(i[0]=()=>{p(!0)})},[t(e(l),{icon:"Trash2",class:"w-4 h-4 mr-1"}),r(" Delete ")])])]),_:1})]),_:2},1024))),128))]),_:1})]),_:1})]),o("div",Y,[t(e(n),{class:"w-full sm:w-auto sm:mr-auto"},{default:s(()=>[t(e(n).Link,null,{default:s(()=>[t(e(l),{icon:"ChevronsLeft",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:s(()=>[t(e(l),{icon:"ChevronLeft",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:s(()=>[r("...")]),_:1}),t(e(n).Link,null,{default:s(()=>[r("1")]),_:1}),t(e(n).Link,{active:""},{default:s(()=>[r("2")]),_:1}),t(e(n).Link,null,{default:s(()=>[r("3")]),_:1}),t(e(n).Link,null,{default:s(()=>[r("...")]),_:1}),t(e(n).Link,null,{default:s(()=>[t(e(l),{icon:"ChevronRight",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:s(()=>[t(e(l),{icon:"ChevronsRight",class:"w-4 h-4"})]),_:1})]),_:1}),t(e(C),{class:"w-20 mt-3 !box sm:mt-0"},{default:s(()=>[Z,ee,te,se]),_:1})])]),t(e(y),{open:m.value,onClose:i[2]||(i[2]=()=>{p(!1)}),initialFocus:x.value},{default:s(()=>[t(e(y).Panel,null,{default:s(()=>[o("div",oe,[t(e(l),{icon:"XCircle",class:"w-16 h-16 mx-auto mt-3 text-danger"}),re,ae]),o("div",le,[t(e(_),{variant:"outline-secondary",type:"button",onClick:i[1]||(i[1]=()=>{p(!1)}),class:"w-24 mr-1"},{default:s(()=>[r(" Cancel ")]),_:1}),t(e(_),{variant:"danger",type:"button",class:"w-24",ref_key:"deleteButtonRef",ref:x},{default:s(()=>[r(" Delete ")]),_:1},512)])]),_:1})]),_:1},8,["open","initialFocus"])],64))}});export{pe as default};
