//Hover vào sao thứ i thì i sao đầu sáng
const hover_stars = document.querySelectorAll('.rating_star');

hover_stars.forEach(star => {
  star.addEventListener('mouseover', function() {
    const hover_num = parseInt(this.getAttribute('data-index'));
    hover_stars.forEach((s, i) => {
      if(i < hover_num){
        s.src="./assets/images/icons8-star-filled-96.png"
      }
    });
  });
  star.addEventListener('mouseout', function() {
    hover_stars.forEach(s => s.src = './assets/images/icons8-star-96.png');
  });
});

//Nhấn vào sao thứ i thì i sao đầu sáng và giữ nguyên
const click_stars = document.querySelectorAll('.rating_star');
let rating_num = 0;

function updateStars(rating) {
  click_stars.forEach((s, i) => {
    if (i < rating) {
      s.src = "./assets/images/icons8-star-filled-96.png";
    } else {
      s.src = "./assets/images/icons8-star-96.png";
    }
  });
}

click_stars.forEach(star => {
  star.addEventListener('click', function () {
    rating_num = parseInt(this.getAttribute('data-index'));
    updateStars(rating_num);

    // Gửi số sao về server
    fetch('rating.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'rating=' + encodeURIComponent(rating_num)
    })
    .then(response => response.text())
    .then(data => {
      // Xử lý phản hồi nếu cần
      console.log('Đã gửi số sao:', rating_num);
    });
  });

  star.addEventListener('mouseover', function () {
    const hover_rating = parseInt(this.getAttribute('data-index'));
    updateStars(hover_rating);
  });

  star.addEventListener('mouseout', function () {
    updateStars(rating_num);
  });
});

//Cập nhật số kí tự sau mỗi lần gõ
const comment_input = document.querySelector('.comment_body_right_input');
const charCountDisplay = document.querySelector('.comment_limit');

comment_input.addEventListener('input', function () {
  let currentText = comment_input.value;
  if (currentText.length > 1000) {
    comment_input.value = currentText.slice(0, 1000);
    currentText = comment_input.value;
  }
  charCountDisplay.textContent = currentText.length + '/1000';
});

const clear_click = document.querySelector('#clear_button');
const comment_input_2 = document.querySelector('.comment_body_right_input');
const charCountDisplay_2 = document.querySelector('.comment_limit');

//Xoá nội dung ô input khi nhấn nút clear
clear_click.addEventListener('click', function() {
  comment_input_2.value = '';
  charCountDisplay_2.textContent = '0/1000';
});

const like_click = document.querySelector('#like_button');
let like_count = 0;
if (like_click) {
  like_click.addEventListener('click', function() {
    const like_count_display = document.querySelector('#like_number');
    like_count++;
    like_click.src = './assets/images/icons8-like-filled-96.png';
    like_count_display.textContent = like_count;
    // Lấy commentId từ phần tử hoặc context phù hợp
    const commentId = like_click.getAttribute('data-commentid') || 0;
    fetch('comment.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'action=like_comment&comment_id=' + encodeURIComponent(commentId)
    })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        // Cập nhật giao diện nếu cần
        alert('Đã like!');
      }
    });
  });
}

const dislike_click = document.querySelector('#dislike_button');
let dislike_count = 0;
if (dislike_click) {
  dislike_click.addEventListener('click', function() {
    const dislike_count_display = document.querySelector('#dislike_number');
    dislike_count++;
    dislike_click.src = './assets/images/icons8-dislike-filled-96.png';
    dislike_count_display.textContent = dislike_count;
    fetch('dislike.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'dislike_count=' + encodeURIComponent(dislike_count)
    })
    .then(response => response.text())
    .then(() => {
      console.log('Dislike count updated successfully');
    });
  });
}

// Hàm lấy tham số từ URL
function getQueryParam(name) {
    const url = new URL(window.location.href);
    return url.searchParams.get(name);
}

async function checkUserCommented(truyenID, userID) {
    const res = await fetch(`comment.php?action=check_user_commented&truyen_id=${truyenID}&user_id=${userID}`);
    const data = await res.json();
    return {
        commented: data.commented,
        userID: userID,
        truyenID: truyenID
    };
}

let allCommentsTree = [];
let commentsPerPage = 5;
let currentPage = 1;
let currentOrder = 'desc'; // Mặc định mới nhất

function renderCommentsPage() {
    const commentList = document.querySelector('.show_comment_body_right');
    commentList.innerHTML = '';
    const start = 0;
    const end = currentPage * commentsPerPage;
    const commentsToShow = allCommentsTree.slice(start, end);
    commentsToShow.forEach(cmt => {
        commentList.innerHTML += renderComment(cmt, 0);
    });
    attachReplyEvents();

    // Hiện nút "Xem thêm" nếu còn bình luận chưa hiển thị
    let showMoreBtn = document.getElementById('show-more-comments');
    if (!showMoreBtn) {
        showMoreBtn = document.createElement('button');
        showMoreBtn.id = 'show-more-comments';
        showMoreBtn.className = 'btn btn-outline-secondary mt-2';
        showMoreBtn.textContent = 'Xem thêm bình luận...';
        commentList.parentNode.appendChild(showMoreBtn);
    }
    if (end >= allCommentsTree.length) {
        showMoreBtn.style.display = 'none';
    } else {
        showMoreBtn.style.display = 'block';
        showMoreBtn.onclick = function() {
            currentPage++;
            renderCommentsPage();
        };
    }
}

function loadAllCommentsByTime(truyenID, chapterID = null, order = 'desc') {
    let url = `comment.php?action=get_all_comments_by_time&truyen_id=${truyenID}&order=${order}`;
    if (chapterID) url += `&chapter_id=${chapterID}`;
    fetch(url)
        .then(res => res.json())
        .then(comments => {
            const tree = buildCommentTree(comments);
            allCommentsTree = tree;
            currentPage = 1;
            renderCommentsPage();
        });
}

// Lọc theo like
function loadAllCommentsByLike(truyenID) {
    fetch(`comment.php?action=get_all_comments_by_like&truyen_id=${truyenID}`)
        .then(res => res.json())
        .then(comments => {
            const tree = buildCommentTree(comments);
            allCommentsTree = tree;
            currentPage = 1;
            renderCommentsPage();
        });
}

// Hàm gửi bình luận
function postComment() {
    const commentInput = document.querySelector('.comment_body_right_input');
    const comment = commentInput.value.trim();
    const charCountDisplay = document.querySelector('.comment_limit');
    const dateTimePost = new Date();
    const date_time_post = dateTimePost.toISOString().slice(0, 19).replace('T', ' ');

    // Lấy id truyện và user từ URL (?truyen_id=...&user_id=...)
    const truyenID = getQueryParam('truyen_id') || 2;
    const userID = getQueryParam('user_id') || 1;

    if (!comment) {
        alert('Vui lòng nhập nội dung bình luận!' + userID + truyenID);
        return;
    }

    checkUserCommented(truyenID, userID).then(result => {
        if (result.commented) {
            alert('Bạn đã bình luận cho truyện này!');
        } else {
            fetch('comment.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=add&AccountID=${account_id}&TruyenID=${truyen_id}&Comment=${encodeURIComponent(comment)}`
            })
            .then(res => res.text())
            .then(msg => {
                alert(msg);
                commentInput.value = '';
                charCountDisplay.textContent = '0/1000';
                loadAllCommentsByTime(truyenID);
            });
        }
    });
}

// Gọi hàm này khi trang load
document.addEventListener('DOMContentLoaded', function() {
    const truyenID = window.currentTruyenId;
    const chapterID = window.currentChapterId;
    const filter = document.querySelector('.comment_filter_dropdown');
    filter.addEventListener('change', function() {
        if (filter.value === 'like') {
            loadAllCommentsByLike(truyenID, chapterID);
        } else {
            loadAllCommentsByTime(truyenID, chapterID, filter.value);
        }
    });
    // Gọi mặc định khi load trang
    loadAllCommentsByTime(truyenID, chapterID, 'desc');

    // Gắn sự kiện cho nút gửi bình luận
    const post_click = document.querySelector('#post_button');
    if (post_click) {
        post_click.addEventListener('click', function() {
            const comment = document.querySelector('.comment_body_right_input').value.trim();
            const truyen_id = window.currentTruyenId;
            const chapter_id = window.currentChapterId || null;
            const account_id = window.currentAccountId;
            if (!comment) return alert('Vui lòng nhập bình luận!');
            if (!account_id) return alert('Bạn cần đăng nhập để bình luận!');
            // SỬA Ở ĐÂY: Nếu có chapter_id thì truyền, nếu không thì không truyền
            let bodyData = `action=add&AccountID=${account_id}&TruyenID=${truyen_id}&Comment=${encodeURIComponent(comment)}`;
            if (chapter_id) bodyData += `&ChapterID=${chapter_id}`;
            fetch('comment.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: bodyData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Đăng bình luận thành công!');
                    document.querySelector('.comment_body_right_input').value = '';
                    document.querySelector('.comment_limit').textContent = '0/1000';
                    loadAllCommentsByTime(truyen_id, chapter_id);
                } else {
                    alert('Có lỗi xảy ra!');
                }
            });
        });
    }
});


function renderComment(cmt, level = 0) {
    let repliesHtml = '';
    let toggleReplyBtn = '';
    if (cmt.replies && cmt.replies.length > 0) {
        toggleReplyBtn = `<button class="show_action_button toggle-replies-btn btn btn-light btn-sm ms-2" data-commentid="${cmt.CommentID}">Hiện phản hồi</button>`;
        repliesHtml = `
            <div class="replies-list" data-parentid="${cmt.CommentID}">
                ${cmt.replies.map(reply => renderComment(reply, level + 1)).join('')}
            </div>
        `;
    }
    return `
    <div class="comment-item mb-3" data-commentid="${cmt.CommentID}" style="margin-left:${level * 30}px;">
        <div class="show_comment_body_right_top p-2">
            <b>${cmt.username ? cmt.username : 'User ' + cmt.AccountID}:</b> ${cmt.Comment}
        </div>
        <div class="show_comment_body_right_bottom mt-1 d-flex align-items-center flex-wrap gap-2">
            <button class="show_action_button like_button btn btn-light btn-sm" data-commentid="${cmt.CommentID}">
                <img src="./assets/images/likebutton.png" alt="" class="show_action_button_icon">
                <span class="show_action_button_text">Like</span>
                <span class="show_action_button_number like_number">${cmt.LikeCount ?? 0}</span>
            </button>
            <button class="show_action_button dislike_button btn btn-light btn-sm" data-commentid="${cmt.CommentID}">
                <img src="./assets/images/dislikebutton.png" alt="" class="show_action_button_icon">
                <span class="show_action_button_text">Dislike</span>
                <span class="show_action_button_number dislike_number">${cmt.DislikeCount ?? 0}</span>
            </button>
            <button class="show_action_button reply-btn btn btn-light btn-sm" data-parentid="${cmt.CommentID}">
                <img src="./assets/images/feedback.png.png" alt="" class="show_action_button_icon">
                <span class="show_action_button_text">Phản hồi</span>
            </button>
            ${cmt.replies && cmt.replies.length > 0 ? `
            <button class="show_action_button toggle-replies-btn btn btn-light btn-sm ms-2" data-commentid="${cmt.CommentID}">Ẩn phản hồi</button>
            ` : ''}
            <span class="show_date_time_post ms-2">${cmt.Date_Time_Post ?? ''}</span>
        </div>
        <div class="reply-box" style="display:none; margin-top:8px;">
            <textarea class="reply-input form-control mb-2" rows="2" style="width:100%;"></textarea>
            <button class="btn btn-primary btn-sm send-reply-btn" data-parentid="${cmt.CommentID}">Gửi</button>
        </div>
        ${repliesHtml}
    </div>
    `;
}

function attachReplyEvents() {
    document.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const commentItem = this.closest('.comment-item');
            const replyBox = commentItem.querySelector('.reply-box');
            replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
        });
    });
    document.querySelectorAll('.like_button').forEach(btn => {
        btn.onclick = function() {
            const commentId = this.getAttribute('data-commentid');
            fetch('comment.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=like_comment&comment_id=${commentId}&user_id=${window.currentAccountId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadAllCommentsByTime(window.currentTruyenId, window.currentChapterId, 'desc');
                }
            });
        };
    });
    document.querySelectorAll('.dislike_button').forEach(btn => {
        btn.onclick = function() {
            const commentId = this.getAttribute('data-commentid');
            fetch('comment.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=dislike_comment&comment_id=${commentId}&user_id=${window.currentAccountId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadAllCommentsByTime(window.currentTruyenId, window.currentChapterId, 'desc');
                }
            });
        };
    });
    document.querySelectorAll('.send-reply-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const parentID = this.getAttribute('data-parentid');
            const commentItem = this.closest('.comment-item');
            const replyInput = commentItem.querySelector('.reply-input');
            const replyContent = replyInput.value.trim();
            if (!replyContent) return alert('Vui lòng nhập nội dung phản hồi!');
            const truyen_id = window.currentTruyenId;
            const account_id = window.currentAccountId;
            fetch('comment.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=add&AccountID=${account_id}&TruyenID=${truyen_id}&Comment=${encodeURIComponent(replyContent)}&ParentID=${parentID}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    replyInput.value = '';
                    loadAllCommentsByTime(truyen_id);
                } else {
                    alert('Có lỗi xảy ra!');
                }
            });
        });
    });
    document.querySelectorAll('.toggle-replies-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const commentId = this.getAttribute('data-commentid');
        const repliesList = document.querySelector(`.replies-list[data-parentid="${commentId}"]`);
        if (repliesList) {
            if (repliesList.style.display === 'none') {
                repliesList.style.display = '';
                this.textContent = 'Ẩn phản hồi';
            } else {
                repliesList.style.display = 'none';
                this.textContent = 'Hiện phản hồi';
            }
        }
    });
 });
}

function buildCommentTree(comments) {
    const map = {};
    const roots = [];
    comments.forEach(cmt => {
        cmt.replies = [];
        map[cmt.CommentID] = cmt;
    });
    comments.forEach(cmt => {
        if (cmt.ParentID && map[cmt.ParentID]) {
            map[cmt.ParentID].replies.push(cmt);
        } else {
            roots.push(cmt);
        }
    });
    return roots;
}
