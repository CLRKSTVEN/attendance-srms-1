(function ensureJQ(){
  function start(){
    if (!window.jQuery) return setTimeout(start, 50);
    (function($){

      (function () {
        if (window.__REQ_BELL_INIT) return;
        window.__REQ_BELL_INIT = true;

        var POLL_MS = 30000;
        var INCLUDE_PROCESSING = false;

        function fmtDate(s) {
          if (!s) return "";
          try {
            return new Date(s.replace(" ", "T")).toLocaleString();
          } catch (e) {
            return s;
          }
        }

        function renderItem(baseHref, row) {
          var title = row.document_type || "Document";
          var meta = "By " + (row.student || "—") + " · " + fmtDate(row.request_date || "");
          var href = baseHref || "#";

          return [
            '<a class="req-item" href="', href, '">',
              '<div class="req-title">', title, '</div>',
              '<div class="req-meta"><span>', meta, '</span></div>',
            '</a>'
          ].join("");
        }

        function refreshCount($b) {
          var url = $b.data("count-url");
          if (!url) return;
          $.getJSON(url, { include_processing: INCLUDE_PROCESSING ? 1 : 0 }).done(function (resp) {
            var n = Number((resp && resp.count) || 0);
            var $badge = $b.find(".req-badge");
            if (n > 0) { $badge.text(n).show(); } else { $badge.hide().text("0"); }
          });
        }

        function refreshList($b) {
          var url = $b.data("list-url");
          if (!url) return;

          $.getJSON(url, { include_processing: INCLUDE_PROCESSING ? 1 : 0, limit: 8 }).done(function (resp) {
            var rows = (resp && resp.data) || [];
            var $list = $b.find(".req-list");
            var $empty = $b.find(".req-empty");
            if (!rows.length) { $list.empty(); $empty.show(); return; }
            $empty.hide();
            var baseHref = $b.data("index-url") || "#";
            $list.html(rows.map(function (r) { return renderItem(baseHref, r); }).join(""));
          });
        }

        function tick() {
          $(".req-bell").each(function () {
            var $b = $(this);
            refreshCount($b);
            refreshList($b);
          });
        }

        $(function () {
          tick();
          setInterval(tick, POLL_MS);

          $(document).on("shown.bs.dropdown", ".req-bell", function () {
            var $b = $(this);
            $b.find(".req-badge").text("0").hide();
            var mark = $b.data("markseen-url");
            if (mark) $.post(mark);
          });

          $(document).on("click", ".req-bell .req-list a", function () {
            var $b = $(this).closest(".req-bell");
            $b.find(".req-badge").text("0").hide();
            var mark = $b.data("markseen-url");
            if (mark) $.post(mark);
          });
        });
      })();
      /* ====== END: original req-bell.js logic ====== */

    })(jQuery);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start);
  } else {
    start();
  }
})();
