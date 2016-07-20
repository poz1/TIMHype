$(document).ready(documentReady);


function documentReady() {

    /*  APRE E CHIUDE MENU MOBILE   */
    $('body').on('click', ".mobile-menu", function () {
        if (!$(".lower-header").hasClass("visible"))
            $(".lower-header").addClass("visible");
        else
            $(".lower-header").removeClass("visible");
    });

    /*  APRE E CHIUDE MENU CATEGORIES OF DEVICES   */
    $('body').on('click', "#CategoriesFilter", function () {
        if (!$(".devices-filter-categories-main-box").hasClass("visible"))
            $(".devices-filter-categories-main-box").addClass("visible");
        else
            $(".devices-filter-categories-main-box").removeClass("visible");
    });

    /*  APRE E CHIUDE MENU BRAND OF DEVICES   */
    $('body').on('click', "#BrandFilter", function () {
        if (!$("#BradFilterItems").hasClass("visible"))
            $("#BradFilterItems").addClass("visible");
        else
            $("#BradFilterItems").removeClass("visible");
    });

    /*  APRE E CHIUDE MENU PRICE OF DEVICES   */
    $('body').on('click', "#PriceFilter", function () {
        if (!$("#PriceFilterItems").hasClass("visible"))
            $("#PriceFilterItems").addClass("visible");
        else
            $("#PriceFilterItems").removeClass("visible");
    });

    /*  APRE E CHIUDE MENU ASSISTANCE SERVICES   */
    $('body').on('click', "#AssistanceServicesTitle", function () {
        if (!$("#AssistanceServices").hasClass("visible"))
            $("#AssistanceServices").addClass("visible");
        else
            $("#AssistanceServices").removeClass("visible");
    });

    /*  APRE E CHIUDE MENU SMARTLIFE SERVICES   */
    $('body').on('click', "#SmartLifeServicesTitle", function () {
        if (!$("#SmartLifeServices").hasClass("visible"))
            $("#SmartLifeServices").addClass("visible");
        else
            $("#SmartLifeServices").removeClass("visible");
    });

     /*  APRE E CHIUDE MENU VARI   */
    $('body').on('click', "#CollapsableTitle", function () {
        if (!$("#Collapsable").hasClass("visible"))
            $("#Collapsable").addClass("visible");
        else
            $("#Collapsable").removeClass("visible");
    });

    /*  EVIDENZIA MENU CORRENTE   */
    $(".navigation-menu li").click(function () {
        $(this).siblings('li').removeClass('navigation-item-active').addClass('navigation-item');
        $(this).removeClass('navigation-item').addClass('navigation-item-active');
    });

    /*  CAMBIO CONTENUTO PAGINA DA MENU LATERALE   */
    /*  WHO WE ARE  */
    $(".who-we-are").click(function (event) {

        var id = event.target.id;

        if (id == "Innovation") {
            getInnovation();
        }

        if (id == "Testimonials") {
            getTestimonials();
        }

        if (id == "Projects") {
            getProjects();
        }
    });

    /*  THE GROUP   */
    $(".the-group").click(function (event) {

        var id = event.target.id;

        if (id == "Description") {
            getDescription();
        }

        if (id == "News") {
            getNews();
        }

        if (id == "Governance") {
            getGovernance();
        }

        if (id == "BusinessMarket") {
            getBusinessMarket();
        }

        if (id == "ForInvestors") {
            getForInvestors();
        }
    });
    /*  END OF CAMBIO CONTENUTO PAGINA DA MENU LATERALE   */
}

/*  FUNCTIONS TO GET PAGES CONTENT   */

/*  HEADER  */
function getHeader(page) {
    $("#header").load("pages/header.html", function () {
        $("#" + page).addClass(" menu-item-active");
    });
}

/*  WHO WE ARE    */
function getInnovation() {
    $("#content").load("pages/who_we_are/innovation.html");
}

function getTestimonials() {
    $("#content").load("pages/who_we_are/testimonials.html");
}

function getProjects() {
    $("#content").load("pages/who_we_are/projects.html");
}

/*  THE GROUP    */
function getDescription() {
    $("#content").load("pages/the_group/description.html");
}

function getNews() {
    $("#content").load("pages/the_group/news.html");
}

function getGovernance() {
    $("#content").load("pages/the_group/governance.html");
}

function getBusinessMarket() {
    $("#content").load("pages/the_group/businessMarket.html");
}

function getForInvestors() {
    $("#content").load("pages/the_group/forInvestors.html");
}

/*  SMART LIFE SERVICES     */
function getSmartLifeServices() {
    $("#content").load("pages/smartlife/smartlifeservices.html");
}

function getSmartLifeService() {
    $("#content").load("pages/smartlife/sldetail.html");
}
/*  END OF FUNCTIONS TO GET PAGES CONTENT   */

/*  DEVICE  */
var selectedDeviceCategory;

/*  EVIDENZIA CATEGORY CORRENTE   */
function highlightCurrentDeviceCategory() {
    $('.devices-filter-category-description').each(function (i, e) {
        $(e).click(function () {

            $('.devices-filter-category-description').each(function (t, v) {
                $(v).removeClass('devices-filter-category-description-active');
            });

            $(this).addClass('devices-filter-category-description-active');

            selectedDeviceCategory = this.getElementsByTagName('a')[0].id;
            getDevicesFromDB();
        })
    });
}

function getDeviceFromDB(id) {
    $.ajax({
        method: "GET",
        data: { Type: "getDevice", DeviceId: id },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/devices.php",

        success: function (response) {
            $(".content").html(response);
            getAssistanceServicesForDevice(id);

            if ($(window).width() < 1023)
                $("#Sidebar").appendTo("#deviceDetail");
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getDevicesFromDB() {

    var brandArray = [];

    $('.brand').each(function (i, e) {
        if (e.checked)
            brandArray.push($(e).attr('id'));
    });

    var priceMin = document.getElementById("MinInput").value;
    var priceMax = document.getElementById("MaxInput").value;

    $.ajax({
        method: "GET",
        data: { Type: "getDevices", Brand: brandArray, PriceMin: priceMin, PriceMax: priceMax, Category: selectedDeviceCategory },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/devices.php",

        success: function (response) {

            if (response == "Niente") {
                $(".devices-device-list").html("Nessun risultato per la richerca effettuata");
            }

            $(".devices-device-list").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getAssistanceServicesForDevice(id) {
    $.ajax({
        method: "GET",
        data: { Type: "getAssistanceServices", DeviceId: id },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/devices.php",

        success: function (response) {
            $("#AssistanceServices").html(response);
            getSmartLifeServicesForDevice(id);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getSmartLifeServicesForDevice(id) {
    $.ajax({
        method: "GET",
        data: { Type: "getSmartLifeServices", DeviceId: id },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/devices.php",

        success: function (response) {
            $("#SmartLifeServices").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getCategoriesBrandsDevicesFromDB() {
    selectedDeviceCategory = $("#AllCategories").attr('id');

    $.ajax({
        method: "GET",
        data: { Type: "getCategories" },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/devices.php",

        success: function (response) {

            $(".devices-filter-categories-box").html(response);

            getBrandsDevicesFromDB();
            highlightCurrentDeviceCategory();
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getBrandsDevicesFromDB() {
    $.ajax({
        method: "GET",
        data: { Type: "getBrands" },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/devices.php",

        success: function (response) {
            $(".devices-filter-fields-box").html(response);
            getDevicesFromDB();
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function navigateToDeviceDetailPage(id,promotion) {
    window.location.href = 'device.html?Id=' + id + "&Promotion=" + promotion;
}

function navigateToBuyDeviceFormPage(id) {
    window.location.href = 'buydevice.html?Id=' + id;
}

function navigateToBuySmartLifeFormPage(id) {
    window.location.href = 'buysmartlifeservice.html?Id=' + id;
}

function navigateToAssistanceFormPage(id) {
    window.location.href = 'assistancerequest.html?Id=' + id;
}

/*  ASSISTANCE SERVICES  */
var selectedAssistanceServiceCategory;

function getAssistanceServicesFromDB() {
    $.ajax({
        method: "GET",
        data: { Type: "getAssistanceServices", Category: selectedAssistanceServiceCategory },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/assistanceServices.php",

        success: function (response) {
            $(".assistance-services-list-box").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

/*  EVIDENZIA CATEGORY CORRENTE   */
function highlightCurrentAssistanceServiceCategory() {

    $('.devices-filter-category-description').each(function (i, e) {
        $(e).click(function () {

            $('.devices-filter-category-description').each(function (t, v) {
                $(v).removeClass('devices-filter-category-description-active');
            });

            $(this).addClass('devices-filter-category-description-active');

            selectedAssistanceServiceCategory = this.getElementsByTagName('a')[0].id;
            getAssistanceServicesFromDB();
        })
    });
}

function getAssistanceServicesCategoriesFromDB() {
    selectedAssistanceServiceCategory = 0;

    $.ajax({
        method: "GET",
        data: { Type: "getCategories" },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/assistanceServices.php",

        success: function (response) {
            $(".assistance-service-filter-fields-box").html(response);
            getAssistanceServicesFromDB();
            highlightCurrentAssistanceServiceCategory();
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getAssistanceServiceFromDB(assistanceService) {
    $.ajax({
        method: "GET",
        data: { Type: "getAssistanceService", AssistanceServiceId: assistanceService },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/assistanceServices.php",

        success: function (response) {
            $(".content-container").html(response);

            if ($(window).width() < 1023)
                $("#Sidebar").appendTo("#Content");
            
            getDevicesForAssistanceService(assistanceService);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getDevicesForAssistanceService(id) {
    $.ajax({
        method: "GET",
        data: { Type: "getDevices", Id: id },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/assistanceServices.php",

        success: function (response) {
            $(".devices-filter-fields-box-from-DB").after(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getHighlightsAssistanceServiceFromDB() {
    $.ajax({
        method: "GET",
        data: { Type: "getHighlights" },
        crossDomain: true,
        url: "php/assistanceServices.php",

        success: function (response) {
            $(".content-container").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getHighlightsMenu(id){
    $.ajax({
        method: "GET",
        data: { Type: "getHighlightsMenu", ID: id },
        crossDomain: true,
        url: "php/assistanceServices.php",

        success: function (response) {
           $(".highlights-menu").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function navigateToAssistanceServicesDetailPage(assistanceservice, highlight, promotion) {
    window.location.href = 'assistance_service.html?Id=' + assistanceservice + "&Highlight=" + highlight + "&Promotion=" + promotion;
}

/*SMART LIFE SERVICES */
var selectedSmartLifeServiceCategory;

/*  EVIDENZIA CATEGORY CORRENTE   */
function highlightCurrentSmartLifeServiceCategory() {

    $('.devices-filter-category-description').each(function (i, e) {
        $(e).click(function () {

            $('.devices-filter-category-description').each(function (t, v) {
                $(v).removeClass('devices-filter-category-description-active');
            });

            $(this).addClass('devices-filter-category-description-active');

            selectedSmartLifeServiceCategory = this.getElementsByTagName('a')[0].id;
            getSmartLifeServicesFromDB();
        })
    });
}

function getSmartLifeServicesCategoriesFromDB() {
    selectedSmartLifeServiceCategory = 0;

     $.ajax({
        method: "GET",
        data: { Type: "getCategories" },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/smartLifeServices.php",

        success: function (response) {
            $(".smartlife-service-filter-fields-box").html(response);
            getSmartLifeServicesFromDB();
            highlightCurrentSmartLifeServiceCategory();
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getSmartLifeServicesFromDB() {
    $.ajax({
        method: "GET",
        data: { Type: "getServices", Category: selectedSmartLifeServiceCategory },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/smartLifeServices.php",

        success: function (response) {
            $(".smartlife-container").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getSmartLifeServiceFromDB(id) {
    $.ajax({
        method: "GET",
        data: { Type: "getService", Id: id },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/smartLifeServices.php",

        success: function (response) {
            $(".content-container").html(response);

            if ($(window).width() < 1023)
                $("#Sidebar").appendTo("#Content");
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getDevicesForSmartLifeService(id){
    $.ajax({
        method: "GET",
        data: { Type: "getDevices", Id: id },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/smartLifeServices.php",

        success: function (response) {
            console.log(response);
            $(".devices").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function navigateToSmartlifeServiceDetailPage(id, promotion) {
    window.location.href = 'smartlife_service.html?Id=' + id + "&Promotion=" + promotion;
}

function navigateToDevicesForSmartLifeService(id) {
    window.location.href = 'device_for_smartlife_service.html?Id=' + id;
}

/*FINE SMART LIFE SERVICES */

function getParameters() {
    var query_string = {};
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        // If first entry with this name
        if (typeof query_string[pair[0]] === "undefined") {
            query_string[pair[0]] = decodeURIComponent(pair[1]);
            // If second entry with this name
        } else if (typeof query_string[pair[0]] === "string") {
            var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
            query_string[pair[0]] = arr;
            // If third or later entry with this name
        } else {
            query_string[pair[0]].push(decodeURIComponent(pair[1]));
        }
    }
    return query_string;
};


function findActive() {
   return document.getElementsByClassName("navigation-item-active")[0].id;
}

//PROMOTION

function getPromotionMenu(id, item) {
     $.ajax({
        method: "GET",
        data: { Type: "getPromotionsMenu", Id: id, Item: item },
        crossDomain: true,
        url: "php/promotion.php",

        success: function (response) {
            console.log(response);
           $(".promotion-menu").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function getPromotionsFromDB() {

    $.ajax({
        method: "GET",
        data: { Type: "getPromotions"},
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/promotion.php",

        success: function (response) {
            $(".promotions-list-realsize").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

//FORM 

function getBuyInfoFromDB(device, type) {
    $.ajax({
        method: "GET",
        data: { Type: "BuyDevice", DeviceId: device, object: type },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/formhelper.php",

        success: function (response) {

            if (response == "Niente") {
                $(".buydevice-info").html("Nessun risultato per la richerca effettuata");
            }

            $(".buydevice-info").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });

    $.ajax({
        method: "GET",
        data: { Type: "getServicesforMenu", DeviceId: device },
        crossDomain: true,
        url: "http://hypetim.azurewebsites.net/php/devices.php",

        success: function (response) {

            if (response == "Niente") {
                $(".connected-services").html("Nessun risultato per la richerca effettuata");
            }

            $(".connected-services").html(response);
        },

        error: function (request, error) {
            console.log("Error");
        }
    });
}

function changeFormText(type) {
    switch (type) {
        case "Device":
            $(".form-data").load("pages/form/device.html");
            break;
        case "Assistance":
            $(".form-data").load("pages/form/assistance.html");
            break;
        case "Smartlife":
            $(".form-data").load("pages/form/smartlife.html");
            break;

    }

}
