import{x as _,s as g,c as b,b as t,d,o as h,e as l,t as r,u as s,i as p,n as v,j as w}from"./app-Clor6Bmc.js";import{_ as y,a as $}from"./TextInput-Dx03gvMx.js";import{_ as k}from"./InputLabel-B8YExcbU.js";import{_ as C}from"./Modal--UPmvu_-.js";import{P as V}from"./PrimaryButton-DOVT375j.js";import{_ as B}from"./SecondaryButton-CVrCLH69.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const S={class:"space-y-6"},x={class:"text-lg font-medium text-slate-900 dark:text-slate-100"},E={class:"my-6 space-y-4"},N={class:"flex justify-end"},T={__name:"Create",props:{show:Boolean,title:String},emits:["close"],setup(u,{emit:f}){const n=u,i=f,e=_({name:""}),c=()=>{e.post(route("permission.store"),{preserveScroll:!0,onSuccess:()=>{i("close"),e.reset()},onError:()=>null,onFinish:()=>null})};return g(()=>{n.show&&(e.errors={})}),(o,a)=>(h(),b("section",S,[t(C,{show:n.show,onClose:a[2]||(a[2]=m=>i("close"))},{default:d(()=>[l("form",{class:"p-6",onSubmit:w(c,["prevent"])},[l("h2",x,r(o.lang().label.add)+" "+r(n.title),1),l("div",E,[l("div",null,[t(k,{for:"name",value:o.lang().label.role},null,8,["value"]),t(y,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:s(e).name,"onUpdate:modelValue":a[0]||(a[0]=m=>s(e).name=m),required:"",placeholder:o.lang().placeholder.name,error:s(e).errors.name},null,8,["modelValue","placeholder","error"]),t($,{class:"mt-2",message:s(e).errors.name},null,8,["message"])])]),l("div",N,[t(B,{disabled:s(e).processing,onClick:a[1]||(a[1]=m=>i("close"))},{default:d(()=>[p(r(o.lang().button.close),1)]),_:1},8,["disabled"]),t(V,{class:v(["ml-3",{"opacity-25":s(e).processing}]),disabled:s(e).processing,onClick:c},{default:d(()=>[p(r(s(e).processing?o.lang().button.add+"...":o.lang().button.add),1)]),_:1},8,["class","disabled"])])],32)]),_:1},8,["show"])]))}};export{T as default};
