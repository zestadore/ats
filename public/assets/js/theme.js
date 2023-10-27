/**
 * Bubbly - Bootstrap 5 Dashboard & CMS Theme v. 1.3.2
 * Homepage:
 * Copyright 2023, Bootstrapious - https://bootstrapious.com
 */

"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // ------------------------------------------------------- //
    // Sidebar
    // ------------------------------------------------------ //

    const sidebarToggler = document.querySelector("#sidebar-toggler");

    if (sidebarToggler) {
        sidebarToggler.addEventListener("click", function (e) {
            if(sidebarToggler.checked){
                // e.preventDefault();
                localStorage.setItem("sideBar", 1);
                document.querySelector(".sidebar").classList.toggle("shrink");
                document.querySelector(".sidebar").classList.toggle("show");
                // $(".sidebar_title").toggle();
                // $(".hidden_icon").toggle();
                // $(".show_icon").toggle();
                $(".sidebar_title").hide();
                $(".hidden_icon").show();
                $(".show_icon").hide();
            }else{
                localStorage.setItem("sideBar", 0);
                document.querySelector(".sidebar").classList.toggle("shrink");
                document.querySelector(".sidebar").classList.toggle("show");
                $(".sidebar_title").show();
                $(".hidden_icon").hide();
                $(".show_icon").show();
            }
            
        });
    }

    

    // ------------------------------------------------------- //
    // Search Dropdown Menu
    // ------------------------------------------------------ //

    const searchFormControl = document.getElementById("searchInput");
    const dropdownMenu = document.getElementById("searchDropdownMenu");

    if (searchFormControl && dropdownMenu) {
        searchFormControl.addEventListener("focus", function (e) {
            var dropdownMenus = [].slice.call(
                document.querySelectorAll(".dropdown-menu.show:not(#searchDropdownMenu)")
            );
            dropdownMenus.map(function (dropdownMenu) {
                dropdownMenu.classList.remove("show");
            });

            dropdownMenu.classList.add("d-block");
        });
        document.addEventListener("click", function (e) {
            if (e.target.id == "searchInput" || e.target.closest("#searchDropdownMenu")) {
                dropdownMenu.classList.add("d-block");
            } else {
                dropdownMenu.classList.remove("d-block");
            }
        });
    }

    // ------------------------------------------------------- //
    // Init Tooltips
    // ------------------------------------------------------ //

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


