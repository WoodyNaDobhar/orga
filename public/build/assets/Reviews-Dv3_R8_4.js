import{d as S,r as w,c as b,a as o,b as t,u as e,w as s,F as v,o as p,h as F,_ as a,e as r,T as i,C as g,f as L,l as D,i as E,t as u,n as T,j as P,k as R,B as k}from"./main-ClqYpcPr.js";import{_ as c}from"./Button.vue_vue_type_script_setup_true_lang-D2jZ4Lmv.js";import{P as n}from"./index-TVazos8f.js";import{_ as y}from"./FormSelect.vue_vue_type_script_setup_true_lang-C_8EpCv5.js";import{T as l}from"./index-Cflwm1k4.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const I=o("h2",{class:"mt-10 text-lg font-medium intro-y"},"Reviews",-1),A={class:"grid grid-cols-12 gap-6 mt-5"},B={class:"flex flex-wrap items-center col-span-12 mt-2 intro-y xl:flex-nowrap"},M={class:"flex w-full sm:w-auto"},N={class:"relative w-48 text-slate-500"},$=o("option",null,"Status",-1),j=o("option",null,"Active",-1),V=o("option",null,"Removed",-1),O=o("div",{class:"hidden mx-auto xl:block text-slate-500"}," Showing 1 to 10 of 150 entries ",-1),U={class:"flex flex-wrap items-center w-full mt-3 xl:w-auto xl:flex-nowrap gap-y-3 xl:mt-0"},q={class:"flex items-center justify-center w-5 h-5"},z={class:"col-span-12 overflow-auto intro-y 2xl:overflow-visible"},G={class:"flex items-center"},H={class:"w-10 h-10 image-fit zoom-in"},X={href:"",class:"ml-4 font-medium whitespace-nowrap"},J={class:"flex items-center underline decoration-dotted",href:"#"},K={class:"flex items-center"},Q={class:"flex items-center"},W=o("div",{class:"ml-1 text-xs text-slate-500"},"(4.5+)",-1),Y={class:"flex items-center justify-center"},Z={class:"flex items-center text-primary whitespace-nowrap",href:"#"},ee={class:"flex flex-wrap items-center col-span-12 intro-y sm:flex-row sm:flex-nowrap"},te=o("option",null,"10",-1),se=o("option",null,"25",-1),oe=o("option",null,"35",-1),re=o("option",null,"50",-1),ae={class:"p-5 text-center"},le=o("div",{class:"mt-5 text-3xl"},"Are you sure?",-1),ne=o("div",{class:"mt-2 text-slate-500"},[r(" Do you really want to delete these records? "),o("br"),r(" This process cannot be undone. ")],-1),de={class:"px-5 pb-8 text-center"},xe=S({__name:"Reviews",setup(ie){const f=w(!1),m=h=>{f.value=h},x=w(null);return(h,_)=>(p(),b(v,null,[I,o("div",A,[o("div",B,[o("div",M,[o("div",N,[t(e(F),{type:"text",class:"w-48 pr-10 !box",placeholder:"Search by name..."}),t(e(a),{icon:"Search",class:"absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3"})]),t(e(y),{class:"w-48 ml-2 xl:w-auto !box"},{default:s(()=>[$,j,V]),_:1})]),O,o("div",U,[t(e(c),{variant:"primary",class:"mr-2 shadow-md"},{default:s(()=>[t(e(a),{icon:"FileText",class:"w-4 h-4 mr-2"}),r(" Export to Excel ")]),_:1}),t(e(c),{variant:"primary",class:"mr-2 shadow-md"},{default:s(()=>[t(e(a),{icon:"FileText",class:"w-4 h-4 mr-2"}),r(" Export to PDF ")]),_:1}),t(e(i),null,{default:s(()=>[t(e(i).Button,{as:e(c),class:"px-2 !box"},{default:s(()=>[o("span",q,[t(e(a),{icon:"Plus",class:"w-4 h-4"})])]),_:1},8,["as"]),t(e(i).Items,{class:"w-40"},{default:s(()=>[t(e(i).Item,null,{default:s(()=>[t(e(a),{icon:"Printer",class:"w-4 h-4 mr-2"}),r(" Print ")]),_:1}),t(e(i).Item,null,{default:s(()=>[t(e(a),{icon:"FileText",class:"w-4 h-4 mr-2"}),r(" Export to Excel ")]),_:1}),t(e(i).Item,null,{default:s(()=>[t(e(a),{icon:"FileText",class:"w-4 h-4 mr-2"}),r(" Export to PDF ")]),_:1})]),_:1})]),_:1})])]),o("div",z,[t(e(l),{class:"border-spacing-y-[10px] border-separate -mt-2"},{default:s(()=>[t(e(l).Thead,null,{default:s(()=>[t(e(l).Tr,null,{default:s(()=>[t(e(l).Th,{class:"border-b-0 whitespace-nowrap"},{default:s(()=>[t(e(g).Input,{type:"checkbox"})]),_:1}),t(e(l).Th,{class:"border-b-0 whitespace-nowrap"},{default:s(()=>[r(" PRODUCT ")]),_:1}),t(e(l).Th,{class:"border-b-0 whitespace-nowrap"},{default:s(()=>[r(" NAME ")]),_:1}),t(e(l).Th,{class:"border-b-0 whitespace-nowrap"},{default:s(()=>[r(" RATING ")]),_:1}),t(e(l).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" POSTED TIME ")]),_:1}),t(e(l).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" STATUS ")]),_:1}),t(e(l).Th,{class:"text-center border-b-0 whitespace-nowrap"},{default:s(()=>[r(" ACTIONS ")]),_:1})]),_:1})]),_:1}),t(e(l).Tbody,null,{default:s(()=>[(p(!0),b(v,null,L(e(P).take(e(R),9),(d,C)=>(p(),D(e(l).Tr,{key:C,class:"intro-x"},{default:s(()=>[t(e(l).Td,{class:"box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[t(e(g).Input,{type:"checkbox"})]),_:1}),t(e(l).Td,{class:"box rounded-l-none rounded-r-none border-x-0 !py-4 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[o("div",G,[o("div",H,[t(e(E),{as:"img",alt:"Midone - HTML Admin Template",class:"border-white rounded-lg border-1 shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]",src:d.images[0],content:`Uploaded at ${d.dates[0]}`},null,8,["src","content"])]),o("a",X,u(d.products[0].name),1)])]),_:2},1024),t(e(l).Td,{class:"box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[o("a",J,u(d.users[0].name),1)]),_:2},1024),t(e(l).Td,{class:"box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[o("div",K,[o("div",Q,[t(e(a),{icon:"Star",class:"w-4 h-4 mr-1 text-pending fill-pending/30"}),t(e(a),{icon:"Star",class:"w-4 h-4 mr-1 text-pending fill-pending/30"}),t(e(a),{icon:"Star",class:"w-4 h-4 mr-1 text-pending fill-pending/30"}),t(e(a),{icon:"Star",class:"w-4 h-4 mr-1 text-pending fill-pending/30"}),t(e(a),{icon:"Star",class:"w-4 h-4 mr-1 text-slate-400 fill-slate/30"})]),W])]),_:1}),t(e(l).Td,{class:"box whitespace-nowrap rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[r(u(d.formattedTimes[0]),1)]),_:2},1024),t(e(l).Td,{class:"box w-40 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"},{default:s(()=>[o("div",{class:T(["flex items-center justify-center",{"text-success":d.trueFalse[0]},{"text-danger":!d.trueFalse[0]}])},[t(e(a),{icon:"CheckSquare",class:"w-4 h-4 mr-2"}),r(" "+u(d.trueFalse[0]?"Active":"Removed"),1)],2)]),_:2},1024),t(e(l).Td,{class:T(["box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600","before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400"])},{default:s(()=>[o("div",Y,[o("a",Z,[t(e(a),{icon:"CheckSquare",class:"w-4 h-4 mr-1"}),r(" View Details ")])])]),_:1})]),_:2},1024))),128))]),_:1})]),_:1})]),o("div",ee,[t(e(n),{class:"w-full sm:w-auto sm:mr-auto"},{default:s(()=>[t(e(n).Link,null,{default:s(()=>[t(e(a),{icon:"ChevronsLeft",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:s(()=>[t(e(a),{icon:"ChevronLeft",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:s(()=>[r("...")]),_:1}),t(e(n).Link,null,{default:s(()=>[r("1")]),_:1}),t(e(n).Link,{active:""},{default:s(()=>[r("2")]),_:1}),t(e(n).Link,null,{default:s(()=>[r("3")]),_:1}),t(e(n).Link,null,{default:s(()=>[r("...")]),_:1}),t(e(n).Link,null,{default:s(()=>[t(e(a),{icon:"ChevronRight",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:s(()=>[t(e(a),{icon:"ChevronsRight",class:"w-4 h-4"})]),_:1})]),_:1}),t(e(y),{class:"w-20 mt-3 !box sm:mt-0"},{default:s(()=>[te,se,oe,re]),_:1})])]),t(e(k),{open:f.value,onClose:_[1]||(_[1]=()=>{m(!1)}),initialFocus:x.value},{default:s(()=>[t(e(k).Panel,null,{default:s(()=>[o("div",ae,[t(e(a),{icon:"XCircle",class:"w-16 h-16 mx-auto mt-3 text-danger"}),le,ne]),o("div",de,[t(e(c),{variant:"outline-secondary",type:"button",onClick:_[0]||(_[0]=()=>{m(!1)}),class:"w-24 mr-1"},{default:s(()=>[r(" Cancel ")]),_:1}),t(e(c),{variant:"danger",type:"button",class:"w-24",ref_key:"deleteButtonRef",ref:x},{default:s(()=>[r(" Delete ")]),_:1},512)])]),_:1})]),_:1},8,["open","initialFocus"])],64))}});export{xe as default};
