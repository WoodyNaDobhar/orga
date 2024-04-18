import{d as b,$ as p,r as G,M as g,l as n,w as d,u as a,o as i,a1 as u,a0 as k,j as y,Y as m,ae as I,a2 as f}from"./main-DasVUAmB.js";const J={inheritAttrs:!1},K=b({...J,__name:"Alert",props:{as:{default:"div"},dismissible:{type:Boolean},variant:{},onShow:{},onShown:{},onHide:{},onHidden:{}},setup(s){const{as:o,dismissible:e,variant:r,...c}=s,t=p(),l=G(!0),x=["bg-primary border-primary text-white","dark:border-primary"],w=["bg-secondary/70 border-secondary/70 text-slate-500","dark:border-darkmode-400 dark:bg-darkmode-400 dark:text-slate-300"],_=["bg-success border-success text-slate-900","dark:border-success"],v=["bg-warning border-warning text-slate-900","dark:border-warning"],h=["bg-pending border-pending text-white","dark:border-pending"],S=["bg-danger border-danger text-white","dark:border-danger"],C=["bg-dark border-dark text-white","dark:bg-darkmode-800 dark:border-transparent dark:text-slate-300"],D=["border-primary text-primary","dark:border-primary"],A=["border-secondary text-slate-500","dark:border-darkmode-100/40 dark:text-slate-300"],B=["border-success text-success dark:border-success","dark:border-success"],P=["border-warning text-warning","dark:border-warning"],$=["border-pending text-pending","dark:border-pending"],j=["border-danger text-danger","dark:border-danger"],F=["border-dark text-dark","dark:border-darkmode-800 dark:text-slate-300"],H=["bg-primary border-primary bg-opacity-20 border-opacity-5 text-primary","dark:border-opacity-100 dark:bg-opacity-20 dark:border-primary"],M=["bg-slate-300 border-secondary bg-opacity-10 text-slate-500","dark:bg-darkmode-100/20 dark:border-darkmode-100/30 dark:text-slate-300"],T=["bg-success border-success bg-opacity-20 border-opacity-5 text-success","dark:border-success dark:border-opacity-20"],W=["bg-warning border-warning bg-opacity-20 border-opacity-5 text-warning","dark:border-warning dark:border-opacity-20"],O=["bg-pending border-pending bg-opacity-20 border-opacity-5 text-pending","dark:border-pending dark:border-opacity-20"],Y=["bg-danger border-danger bg-opacity-20 border-opacity-5 text-danger","dark:border-danger dark:border-opacity-20"],q=["bg-dark border-dark bg-opacity-20 border-opacity-5 text-dark","dark:bg-darkmode-800/30 dark:border-darkmode-800/60 dark:text-slate-300"],z=g(()=>f(["relative border rounded-md px-5 py-4",r=="primary"&&x,r=="secondary"&&w,r=="success"&&_,r=="warning"&&v,r=="pending"&&h,r=="danger"&&S,r=="dark"&&C,r=="outline-primary"&&D,r=="outline-secondary"&&A,r=="outline-success"&&B,r=="outline-warning"&&P,r=="outline-pending"&&$,r=="outline-danger"&&j,r=="outline-dark"&&F,r=="soft-primary"&&H,r=="soft-secondary"&&M,r=="soft-success"&&T,r=="soft-warning"&&W,r=="soft-pending"&&O,r=="soft-danger"&&Y,r=="soft-dark"&&q,e&&"pl-5 pr-16",typeof t.class=="string"&&t.class]));return(E,Q)=>(i(),n(a(I),{as:"template",show:l.value,enter:"transition-all ease-linear duration-150",enterFrom:"invisible opacity-0 translate-y-1",enterTo:"visible opacity-100 translate-y-0",leave:"transition-all ease-linear duration-150",leaveFrom:"visible opacity-100 translate-y-0",leaveTo:"invisible opacity-0 translate-y-1"},{default:d(()=>[(i(),n(u(o),k({role:"alert",class:z.value},a(y).omit(a(t),"class")),{default:d(()=>[m(E.$slots,"default",{dismiss:()=>{l.value=!1}})]),_:3},16,["class"]))]),_:3},8,["show"]))}}),L={inheritAttrs:!1},N=b({...L,__name:"DismissButton",props:{as:{default:"button"}},setup(s){const{as:o}=s,e=p(),r=g(()=>f(["text-slate-800 py-2 px-3 absolute right-0 my-auto mr-2",typeof e.class=="string"&&e.class]));return(c,t)=>(i(),n(u(o),k({type:"button","aria-label":"Close",class:r.value},a(y).omit(a(e),"class")),{default:d(()=>[m(c.$slots,"default")]),_:3},16,["class"]))}}),U=Object.assign({},K,{DismissButton:N});export{U as A};
