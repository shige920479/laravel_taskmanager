$(function () {
    //完了処理ボタンのイベント
    $(".comp-btn").on("click", function () {
        if (confirm("このタスクは完了処理しても宜しいですか？")) {
            $(this).submit();
        } else {
            return false;
        }
    });
    //完全削除ボタンのイベント
    $(".del-btn").on("click", function () {
        if (confirm("完全に削除しますが宜しいですか？")) {
            $(this).submit();
        } else {
            return false;
        }
        //ログアウト
    });
    $("#logout-btn").on("click", function () {
        if (confirm("ログアウトしますか？")) {
            $(this).submit();
        } else {
            return false;
        }
    });
    $("#menu-icon").on("mouseenter", function () {
        $(".menu-content").addClass("open");
    });
    $(".menu-content").on("mouseleave", function () {
        $(this).removeClass("open");
    });

    //ソート
    $("#sort_order").on("change", function () {
        $("#sort").submit();
    });

    //残日数の文字色
    $("td[data-days]").each(function () {
        const days = parseInt($(this).data("days"), 10);
        if (days <= 0) {
            $(this).css("color", "red");
        }
    });

    // チャット内のスクロール最下部表示
    let element = document.getElementById("chat-inner");
    element?.scrollIntoView(false);
});
