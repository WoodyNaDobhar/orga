import{d as b,a9 as x,P as s,s as d,aa as g,Z as y,bY as k,o as _,c as v,Y as V,u as l,j as h}from"./main-BsKWZMZP.js";const w=["type"],T={inheritAttrs:!1},B=b({...T,__name:"FormTextarea",props:{value:{},modelValue:{},formTextareaSize:{},rounded:{type:Boolean}},emits:["update:modelValue"],setup(n,{emit:u}){const e=n,a=x(),i=s("formInline",!1),p=s("inputGroup",!1),c=d(()=>g(["disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent","[&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 [&[readonly]]:dark:border-transparent","transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80",e.formTextareaSize=="sm"&&"text-xs py-1.5 px-2",e.formTextareaSize=="lg"&&"text-lg py-1.5 px-4",e.rounded&&"rounded-full",i&&"flex-1",p&&"rounded-none [&:not(:first-child)]:border-l-transparent first:rounded-l last:rounded-r z-10",typeof a.class=="string"&&a.class])),m=u,r=d({get(){return e.modelValue===void 0?e.value:e.modelValue},set(t){m("update:modelValue",t)}});return(t,o)=>y((_(),v("textarea",V({type:e.type,class:c.value},l(h).omit(l(a),"class"),{"onUpdate:modelValue":o[0]||(o[0]=f=>r.value=f)}),null,16,w)),[[k,r.value]])}});export{B as _};
