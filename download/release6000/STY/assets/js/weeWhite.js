/*
 * @FilePath: /Wee-White/index.js
 * @author: Wibus
 * @Date: 2021-07-23 11:56:27
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-23 17:16:51
 * Coding With IU
 */
function checkClass (arr, v) {
    for (let i = 0; i < arr.length; i++) {
        if (arr[i] == v) {
            return i;
        }
    }
    return -1;
}
var actionSidebar = document.getElementById('action-sidebar')
var actionMenu = document.getElementById('action-menu')
// 手机
function FactionMenu(active){
    var mobileNavbar = document.getElementById('mobile-navbar')
    // console.log('actionMenu')
    if(active == 'end'){
        document.body.classList.remove('active')
        mobileNavbar.classList.remove('active')
    }else{
        document.body.classList.add('active')
        mobileNavbar.classList.add('active')
    }  
}
// 通用
function FactionSidebar(active) {
    var sidebarCollapse = document.getElementById('sidebar-collapse')
    // console.log('actionSidebar')
    if(active == 'end'){
        document.body.classList.remove('active')
        sidebarCollapse.classList.remove('active')
    }else{
        document.body.classList.add('active')
        sidebarCollapse.classList.add('active')
    }    
}