import{x as g,s as _,c as b,b as d,d as c,o as h,e as a,t as s,u as n,i as p,n as k,j as w}from"./app-Clor6Bmc.js";import{D as x}from"./DangerButton-Cz5zDBKP.js";import{_ as y}from"./Modal--UPmvu_-.js";import{_ as B}from"./SecondaryButton-CVrCLH69.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const v={class:"space-y-6"},C={class:"text-lg font-medium text-slate-900 dark:text-slate-100"},S={class:"mt-1 text-sm text-slate-600 dark:text-slate-400"},D={class:"mt-6 flex justify-end"},z={__name:"DeleteBulk",props:{show:Boolean,title:String,selectedId:Object},emits:["close"],setup(u,{emit:f}){const t=u,i=f,e=g({id:[]}),m=()=>{e.post(route("role.destroy-bulk"),{preserveScroll:!0,onSuccess:()=>{i("close"),e.reset()},onError:()=>null,onFinish:()=>null})};return _(()=>{t.show&&(e.id=t.selectedId)}),(o,l)=>(h(),b("section",v,[d(y,{show:t.show,onClose:l[1]||(l[1]=r=>i("close")),maxWidth:"lg"},{default:c(()=>{var r;return[a("form",{class:"p-6",onSubmit:w(m,["prevent"])},[a("h2",C,s(o.lang().label.delete)+" "+s(t.title),1),a("p",S,s(o.lang().label.delete_confirm)+" "+s((r=t.selectedId)==null?void 0:r.length)+" "+s(t.title)+"? ",1),a("div",D,[d(B,{disabled:n(e).processing,onClick:l[0]||(l[0]=$=>i("close"))},{default:c(()=>[p(s(o.lang().button.close),1)]),_:1},8,["disabled"]),d(x,{class:k(["ml-3",{"opacity-25":n(e).processing}]),disabled:n(e).processing,onClick:m},{default:c(()=>[p(s(n(e).processing?o.lang().button.delete+"...":o.lang().button.delete),1)]),_:1},8,["class","disabled"])])],32)]}),_:1},8,["show"])]))}};export{z as default};
