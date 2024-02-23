import{d as k,r as w,f as m,g as s,h as t,w as o,u as e,F as b,j as C,o as u,i as l,T as r,_ as a,m as L,E as P,t as d,q as D,s as F,D as v}from"./main-CeS48KJa.js";import{_}from"./Button.vue_vue_type_script_setup_true_lang-qNMd5tCb.js";import{P as n}from"./index-pRnO0Icy.js";import{_ as T}from"./FormSelect.vue_vue_type_script_setup_true_lang-rccilgeM.js";const S=s("h2",{class:"mt-10 text-lg font-medium intro-y"},"Product Grid",-1),E={class:"grid grid-cols-12 gap-6 mt-5"},B={class:"flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap"},I={class:"flex items-center justify-center w-5 h-5"},N=s("div",{class:"hidden mx-auto md:block text-slate-500"}," Showing 1 to 10 of 150 entries ",-1),R={class:"w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0"},$={class:"relative w-56 text-slate-500"},j={class:"box"},A={class:"p-5"},M={class:"h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"},V=["src"],q={key:0,class:"absolute top-0 z-10 px-2 py-1 m-5 text-xs text-white rounded bg-pending/80"},z={class:"absolute bottom-0 z-10 px-5 pb-6 text-white"},G={href:"",class:"block text-base font-medium"},H={class:"mt-3 text-xs text-white/90"},X={class:"mt-5 text-slate-600 dark:text-slate-500"},J={class:"flex items-center"},K={class:"flex items-center mt-2"},O={class:"flex items-center mt-2"},Q={class:"flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"},U={class:"flex items-center mr-auto text-primary",href:"#"},W={class:"flex items-center mr-3",href:"#"},Y={class:"flex flex-wrap items-center col-span-12 intro-y sm:flex-row sm:flex-nowrap"},Z=s("option",null,"10",-1),ee=s("option",null,"25",-1),te=s("option",null,"35",-1),se=s("option",null,"50",-1),oe={class:"p-5 text-center"},le=s("div",{class:"mt-5 text-3xl"},"Are you sure?",-1),ae=s("div",{class:"mt-2 text-slate-500"},[l(" Do you really want to delete these records? "),s("br"),l(" This process cannot be undone. ")],-1),ne={class:"px-5 pb-8 text-center"},ue=k({__name:"ProductGrid",setup(ie){const h=w(!1),f=x=>{h.value=x},p=w(null);return(x,c)=>(u(),m(b,null,[S,s("div",E,[s("div",B,[t(e(_),{variant:"primary",class:"mr-2 shadow-md"},{default:o(()=>[l(" Add New Product ")]),_:1}),t(e(r),null,{default:o(()=>[t(e(r).Button,{as:e(_),class:"px-2 !box"},{default:o(()=>[s("span",I,[t(e(a),{icon:"Plus",class:"w-4 h-4"})])]),_:1},8,["as"]),t(e(r).Items,{class:"w-40"},{default:o(()=>[t(e(r).Item,null,{default:o(()=>[t(e(a),{icon:"Printer",class:"w-4 h-4 mr-2"}),l(" Print ")]),_:1}),t(e(r).Item,null,{default:o(()=>[t(e(a),{icon:"FileText",class:"w-4 h-4 mr-2"}),l(" Export to Excel ")]),_:1}),t(e(r).Item,null,{default:o(()=>[t(e(a),{icon:"FileText",class:"w-4 h-4 mr-2"}),l(" Export to PDF ")]),_:1})]),_:1})]),_:1}),N,s("div",R,[s("div",$,[t(e(L),{type:"text",class:"w-56 pr-10 !box",placeholder:"Search..."}),t(e(a),{icon:"Search",class:"absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3"})])])]),(u(!0),m(b,null,C(e(D).take(e(F),12),(i,g)=>(u(),m("div",{key:g,class:"col-span-12 intro-y md:col-span-6 lg:col-span-4 xl:col-span-3"},[s("div",j,[s("div",A,[s("div",M,[s("img",{alt:"Midone - HTML Admin Template",class:"rounded-md",src:i.images[0]},null,8,V),i.trueFalse[0]?(u(),m("span",q," Featured ")):P("",!0),s("div",z,[s("a",G,d(i.products[0].name),1),s("span",H,d(i.products[0].category),1)])]),s("div",X,[s("div",J,[t(e(a),{icon:"Link",class:"w-4 h-4 mr-2"}),l(" Price: $ "+d(i.totals[0]),1)]),s("div",K,[t(e(a),{icon:"Layers",class:"w-4 h-4 mr-2"}),l(" Remaining Stock: "+d(i.stocks[0]),1)]),s("div",O,[t(e(a),{icon:"CheckSquare",class:"w-4 h-4 mr-2"}),l(" Status: "+d(i.trueFalse[0]?"Active":"Inactive"),1)])])]),s("div",Q,[s("a",U,[t(e(a),{icon:"Eye",class:"w-4 h-4 mr-1"}),l(" Preview ")]),s("a",W,[t(e(a),{icon:"CheckSquare",class:"w-4 h-4 mr-1"}),l(" Edit ")]),s("a",{class:"flex items-center text-danger",href:"#",onClick:c[0]||(c[0]=y=>{y.preventDefault(),f(!0)})},[t(e(a),{icon:"Trash2",class:"w-4 h-4 mr-1"}),l(" Delete ")])])])]))),128)),s("div",Y,[t(e(n),{class:"w-full sm:w-auto sm:mr-auto"},{default:o(()=>[t(e(n).Link,null,{default:o(()=>[t(e(a),{icon:"ChevronsLeft",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:o(()=>[t(e(a),{icon:"ChevronLeft",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:o(()=>[l("...")]),_:1}),t(e(n).Link,null,{default:o(()=>[l("1")]),_:1}),t(e(n).Link,{active:""},{default:o(()=>[l("2")]),_:1}),t(e(n).Link,null,{default:o(()=>[l("3")]),_:1}),t(e(n).Link,null,{default:o(()=>[l("...")]),_:1}),t(e(n).Link,null,{default:o(()=>[t(e(a),{icon:"ChevronRight",class:"w-4 h-4"})]),_:1}),t(e(n).Link,null,{default:o(()=>[t(e(a),{icon:"ChevronsRight",class:"w-4 h-4"})]),_:1})]),_:1}),t(e(T),{class:"w-20 mt-3 !box sm:mt-0"},{default:o(()=>[Z,ee,te,se]),_:1})])]),t(e(v),{open:h.value,onClose:c[2]||(c[2]=()=>{f(!1)}),initialFocus:p.value},{default:o(()=>[t(e(v).Panel,null,{default:o(()=>[s("div",oe,[t(e(a),{icon:"XCircle",class:"w-16 h-16 mx-auto mt-3 text-danger"}),le,ae]),s("div",ne,[t(e(_),{variant:"outline-secondary",type:"button",onClick:c[1]||(c[1]=()=>{f(!1)}),class:"w-24 mr-1"},{default:o(()=>[l(" Cancel ")]),_:1}),t(e(_),{variant:"danger",type:"button",class:"w-24",ref_key:"deleteButtonRef",ref:p},{default:o(()=>[l(" Delete ")]),_:1},512)])]),_:1})]),_:1},8,["open","initialFocus"])],64))}});export{ue as default};
