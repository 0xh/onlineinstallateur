$(document).ready(function () {

    var strLink = window.location.search.slice(1);

    strLink = strLink.split("=")[1];
    if (strLink) {
        var grupVal = strLink.split(",");
        for (indexGrup = 0; indexGrup < grupVal.length; indexGrup++) {
            grupVal[indexGrup] = grupVal[indexGrup].replace("(", "");
            grupVal[indexGrup] = grupVal[indexGrup].replace(")", "");
            var category = grupVal[indexGrup].split("_")[0];
            var value = grupVal[indexGrup].split("_")[1];
            var valueArr = value.split("|");
            for (index = 0; index < valueArr.length; index++) {
                $("#feature-" + category + "-" + valueArr[index]).prop("checked", "true");
            }
        }
    }

    $(".checkbox-box").click(function () {

        var checkboxBoxArr = [];
        $(".controller_wrapper").each(function () {
            if ($(this).find("input").is(':checked'))
            {
                getCategoryAndValueArr = getCategoryAndValue($(this).find("input").attr('id'));
                if (checkboxBoxArr[getCategoryAndValueArr['category']])
                {
                    checkboxBoxArr[getCategoryAndValueArr['category']] += "|" + getCategoryAndValueArr['value'];

                } else
                {
                    checkboxBoxArr[getCategoryAndValueArr['category']] = getCategoryAndValueArr['value'];
                }
            }

        });

        var str = "";
        for (index = 0; index < checkboxBoxArr.length; index++) {
            if (str)
            {
                if (checkboxBoxArr[index]) {
                    str += "," + index + "_(" + checkboxBoxArr[index] + ")";
                }
            } else
            {
                if (checkboxBoxArr[index]) {
                    str = index + "_(" + checkboxBoxArr[index] + ")";
                }
            }
        }

//        window.history.pushState("object or string", "Title", "?features=" + str + "");
        window.history.replaceState("object or string", "Title", "?" + new Date().getTime() + "&features=" + str + "");
        location.reload();

//        $.ajax({
//            url: window.location.href,
//            type: "post",
////            success: function (data) {
//////                var newDoc = document.open("text/html", "replace");
//////                newDoc.write(data);
//////                newDoc.close();
////            }
//        })
////                .done(function (data) {
//////            var newDoc = document.open("text/html", "replace");
//////            newDoc.write(data);
//////            newDoc.close();
////
////        })
//                .complete(function (data) {
//                    console.log(data);
////                    var newDoc = document.open("text/html", "replace");
//////                    newDoc.write(data.responseText);
////                    newDoc.write(test1 + test);
////                    newDoc.close();
//                    document.open("text/html", "replace");
//                    document.write(data.responseText);
//                    document.close();
//
//                });

    });

    // configurator
    $('.nav-tabs li a').click(function () {

        if ($(this).hasClass("active")) {
            $(".tab-content " + $(this).attr('href')).removeClass('active').removeClass('in');
            $(this).removeClass('active').removeClass('in');
        } else {
            $(".tab-content .tab-pane").removeClass("active");
            $(".tab-content " + $(this).attr('href')).addClass("active").addClass("in");
            $('.main-category .category-head').removeClass('active');
            $(this).addClass('active')
        }

    });

    function getCategoryAndValue(str) {
        var category = str.split("-")[1];
        var value = str.split("-")[2];
        var features = [];
        features['category'] = category;
        features['value'] = value;

        return features;
    }

});