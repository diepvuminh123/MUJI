<?php
require_once(__DIR__ . '/../config/config.php');
$conn = $GLOBALS['conn'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? "Chi tiết bài viết" : "Tin tức" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --gray: #95a5a6;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 30px 0;
        }
        .page-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 32px;
            color: var(--primary);
            position: relative;
            padding-bottom: 10px;
        }
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--secondary);
        }
        .category-nav {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .category-link {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            background: white;
            color: var(--dark);
            text-decoration: none;
            border-radius: 20px;
            font-size: 14px;
            box-shadow: var(--shadow);
            transition: 0.3s;
        }
        .category-link:hover, .category-link.active {
            background: var(--secondary);
            color: white;
        }
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        .article-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s;
        }
        .article-card:hover {
            transform: translateY(-5px);
        }
        .article-image {
            height: 200px;
            overflow: hidden;
        }
        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .article-card:hover .article-image img {
            transform: scale(1.05);
        }
        .article-content {
            padding: 20px;
        }
        .article-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .article-meta {
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .article-excerpt {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .read-more {
            background: var(--secondary);
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .read-more:hover {
            background: #2980b9;
        }
        .article-detail {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            font-size: 18px; /* Increased font size for article detail */
        }
        /* Hiding images in article detail */
        .article-detail img {
            display: none;
        }
        .back-btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #34495e;
        }
        
        /* Comment Section Styles */
        .comment-section {
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }
        .comment-section h3 {
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--primary);
            position: relative;
            padding-bottom: 10px;
        }
        .comment-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--secondary);
        }
        .comment-form input,
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            font-family: inherit;
        }
        .comment-form textarea {
            height: 100px;
            resize: vertical;
        }
        .comment-form button {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-family: inherit;
        }
        .comment-form button:hover {
            background: #2980b9;
        }
        .comment {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .comment-author {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .comment-author strong {
            color: var(--dark);
        }
        .comment-time {
            font-size: 12px;
            color: var(--gray);
        }
        .comment-text {
            margin: 0;
            color: #444;
        }
        .comment-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        .like-button,
        .reply-button {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .like-button {
            color: var(--gray);
            margin-right: 15px;
        }
        .like-button.active {
            color: var(--accent);
        }
        .reply-button {
            color: var(--gray);
        }
        .replies-container {
            margin-left: 20px;
            margin-top: 10px;
        }
        .reply {
            background: #f1f1f1;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .reply-form-container {
            margin-top: 10px;
            margin-left: 20px;
        }
        
        @media (max-width: 768px) {
            .articles-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php include 'Template/Header.php'; ?>

<div class="container">
    <?php if (!$id): ?>
        <h1 class="page-title"><?= $category ? htmlspecialchars($category) : "Tin tức mới nhất" ?></h1>
        <div class="category-nav">
            <a href="index.php?action=listartical" class="category-link <?= !$category ? 'active' : '' ?>">Tất cả</a>
            <?php
            $categories = $conn->query("SELECT DISTINCT category FROM articles ORDER BY category");
            while ($cat = $categories->fetch_assoc()):
            ?>
                <a href="index.php?action=listartical&category=<?= urlencode($cat['category']) ?>"
                   class="category-link <?= $category === $cat['category'] ? 'active' : '' ?>">
                   <?= htmlspecialchars($cat['category']) ?>
                </a>
            <?php endwhile; ?>
        </div>

        <div class="articles-grid">
            <?php
            $query = "SELECT * FROM articles";
            if ($category) {
                $query .= " WHERE category = '$category'";
            }
            $query .= " ORDER BY date DESC";
            $result = $conn->query($query);

            if ($result->num_rows === 0): ?>
                <p style="text-align: center; width: 100%;">Không có bài viết nào.</p>
            <?php else:
                while ($row = $result->fetch_assoc()):
            ?>
                <div class="article-card">
                    <div class="article-image">
                        <img src="../uploads/hot.jpg" alt="<?= htmlspecialchars($row['title']) ?>">
                    </div>
                    <div class="article-content">
                        <h3 class="article-title"><?= htmlspecialchars($row['title']) ?></h3>
                        <div class="article-meta">
                            <span><i class="fas fa-user"></i> <?= htmlspecialchars($row['author']) ?></span>
                            <span><i class="fas fa-calendar"></i> <?= $row['date'] ?></span>
                        </div>
                        <p class="article-excerpt"><?= mb_substr(strip_tags($row['content']), 0, 120) ?>...</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <a class="read-more" href="index.php?action=listartical&id=<?= $row['id'] ?>&category=<?= urlencode($row['category']) ?>">Đọc tiếp</a>
                            <span style="font-size: 13px; color: var(--gray);"><i class="fas fa-eye"></i> <?= $row['views'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; endif; ?>
        </div>
    <?php else:
        $conn->query("UPDATE articles SET views = views + 1 WHERE id = $id");
        $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $article = $stmt->get_result()->fetch_assoc();

        if (!$article): ?>
            <p>Bài viết không tồn tại.</p>
            <a href="index.php?action=listartical" class="back-btn">← Quay lại</a>
        <?php else: ?>
            <div class="article-detail">
                <h1 style="font-size: 32px; margin-bottom: 15px; color: var(--primary);"><?= htmlspecialchars($article['title']) ?></h1>
                <div style="color: gray; margin-bottom: 20px; font-size: 16px;">
                    <i class="fas fa-user"></i> <?= htmlspecialchars($article['author']) ?> |
                    <i class="fas fa-calendar"></i> <?= $article['date'] ?> |
                    <i class="fas fa-tags"></i> <?= $article['category'] ?> |
                    <i class="fas fa-eye"></i> <?= $article['views'] + 1 ?>
                </div>
                <!-- Image removed as requested -->
                <div style="margin-top: 25px; font-size: 18px; line-height: 1.8;"><?= nl2br($article['content']) ?></div>
                
                <!-- Comment Section Start -->
                <div class="comment-section">
                    <h3>Bình luận <span id="comment-count" style="display: inline-block; background: var(--secondary); color: white; font-size: 14px; padding: 2px 8px; border-radius: 10px; margin-left: 10px; font-weight: normal;">0</span></h3>
                    
                    <!-- Sort Options -->
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                        <select id="comment-sort" style="padding: 5px 10px; border: 1px solid #ddd; border-radius: 4px; background: white; color: var(--dark);">
                            <option value="newest">Mới nhất</option>
                            <option value="oldest">Cũ nhất</option>
                            <option value="popular">Phổ biến nhất</option>
                        </select>
                    </div>
                    
                    <!-- Comment Form -->
                    <div class="comment-form" style="margin-bottom: 30px;">
                        <input type="text" id="comment-name" placeholder="Tên của bạn">
                        <textarea id="comment-content" placeholder="Nhập bình luận của bạn..."></textarea>
                        <button id="submit-comment">Gửi bình luận</button>
                    </div>
                    
                    <!-- Comments List -->
                    <div id="comments-container"></div>
                </div>
                <!-- Comment Section End -->
                
                <a href="index.php?action=listartical<?= $category ? '&category='.urlencode($category) : '' ?>" class="back-btn" style="margin-top: 20px;">← Quay lại danh sách</a>
            </div>
            
            <!-- JavaScript for Comments -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get article ID
                const articleId = <?= $id ?>;
                const commentForm = document.querySelector('.comment-form');
                const commentsContainer = document.getElementById('comments-container');
                const nameInput = document.getElementById('comment-name');
                const contentInput = document.getElementById('comment-content');
                const submitButton = document.getElementById('submit-comment');
                const commentCountElement = document.getElementById('comment-count');
                
                // Load comments from localStorage
                function loadComments() {
                    const storageKey = `article_${articleId}_comments`;
                    let comments = JSON.parse(localStorage.getItem(storageKey)) || [];
                    displayComments(comments);
                    return comments;
                }
                
                // Save comments to localStorage
                function saveComments(comments) {
                    const storageKey = `article_${articleId}_comments`;
                    localStorage.setItem(storageKey, JSON.stringify(comments));
                }
                
                // Display comments in the UI
                function displayComments(comments) {
                    commentsContainer.innerHTML = '';
                    
                    if (comments.length === 0) {
                        commentsContainer.innerHTML = '<p style="color: var(--gray); text-align: center;">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>';
                        return;
                    }
                    
                    comments.forEach((comment, index) => {
                        const commentEl = document.createElement('div');
                        commentEl.className = 'comment';
                        
                        const date = new Date(comment.timestamp);
                        const formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()} ${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
                        
                        commentEl.innerHTML = `
                            <div class="comment-author">
                                <strong>${escapeHTML(comment.name)}</strong>
                                <span class="comment-time">${formattedDate}</span>
                            </div>
                            <p class="comment-text">${escapeHTML(comment.content)}</p>
                            <div class="comment-actions">
                                <button class="like-button ${comment.liked ? 'active' : ''}" data-index="${index}">
                                    <i class="fas fa-heart" style="margin-right: 5px;"></i>
                                    <span class="like-count">${comment.likes || 0}</span>
                                </button>
                                <button class="reply-button" data-index="${index}">
                                    <i class="fas fa-reply" style="margin-right: 5px;"></i> Trả lời
                                </button>
                            </div>
                            <div class="replies-container">
                                ${displayReplies(comment.replies || [])}
                            </div>
                            <div class="reply-form-container" data-index="${index}" style="display: none;"></div>
                        `;
                        
                        commentsContainer.appendChild(commentEl);
                    });
                    
                    // Add event listeners for like buttons
                    document.querySelectorAll('.like-button').forEach(button => {
                        button.addEventListener('click', function() {
                            const index = parseInt(this.getAttribute('data-index'));
                            const comments = loadComments();
                            
                            if (!comments[index].liked) {
                                comments[index].likes = (comments[index].likes || 0) + 1;
                                comments[index].liked = true;
                                this.classList.add('active');
                            } else {
                                comments[index].likes = Math.max(0, (comments[index].likes || 0) - 1);
                                comments[index].liked = false;
                                this.classList.remove('active');
                            }
                            
                            saveComments(comments);
                            this.querySelector('.like-count').textContent = comments[index].likes;
                        });
                    });
                    
                    // Add event listeners for reply buttons
                    document.querySelectorAll('.reply-button').forEach(button => {
                        button.addEventListener('click', function() {
                            const index = parseInt(this.getAttribute('data-index'));
                            const replyContainer = document.querySelector(`.reply-form-container[data-index="${index}"]`);
                            
                            // Toggle reply form
                            if (replyContainer.style.display === 'none') {
                                replyContainer.style.display = 'block';
                                replyContainer.innerHTML = `
                                    <div style="margin-bottom: 10px;">
                                        <input type="text" class="reply-name" placeholder="Tên của bạn" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 8px;">
                                        <textarea class="reply-content" placeholder="Nhập trả lời của bạn..." style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; height: 80px;"></textarea>
                                    </div>
                                    <button class="submit-reply" data-index="${index}" style="background: var(--secondary); color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 13px;">Gửi trả lời</button>
                                `;
                                
                                // Auto-fill the name if available
                                const rememberedName = localStorage.getItem('remembered_comment_name');
                                if (rememberedName) {
                                    replyContainer.querySelector('.reply-name').value = rememberedName;
                                }
                                
                                // Add event listener for reply submission
                                replyContainer.querySelector('.submit-reply').addEventListener('click', function() {
                                    const replyIndex = parseInt(this.getAttribute('data-index'));
                                    const replyName = replyContainer.querySelector('.reply-name').value.trim();
                                    const replyContent = replyContainer.querySelector('.reply-content').value.trim();
                                    
                                    if (replyName && replyContent) {
                                        const comments = loadComments();
                                        
                                        if (!comments[replyIndex].replies) {
                                            comments[replyIndex].replies = [];
                                        }
                                        
                                        comments[replyIndex].replies.push({
                                            name: replyName,
                                            content: replyContent,
                                            timestamp: new Date().getTime()
                                        });
                                        
                                        // Save the name for future use
                                        localStorage.setItem('remembered_comment_name', replyName);
                                        
                                        saveComments(comments);
                                        displayComments(comments);
                                        updateCommentCount();
                                    }
                                });
                            } else {
                                replyContainer.style.display = 'none';
                                replyContainer.innerHTML = '';
                            }
                        });
                    });
                }
                
                // Helper function to display replies
                function displayReplies(replies) {
                    if (replies.length === 0) return '';
                    
                    let repliesHTML = '';
                    
                    replies.forEach((reply, index) => {
                        const date = new Date(reply.timestamp);
                        const formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()} ${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
                        
                        repliesHTML += `
                            <div class="reply">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <strong style="color: var(--dark); font-size: 14px;">${escapeHTML(reply.name)}</strong>
                                    <span style="font-size: 11px; color: var(--gray);">${formattedDate}</span>
                                </div>
                                <p style="margin: 0; color: #444; font-size: 14px;">${escapeHTML(reply.content)}</p>
                            </div>
                        `;
                    });
                    
                    return repliesHTML;
                }
                
                // Helper function to escape HTML
                function escapeHTML(str) {
                    const div = document.createElement('div');
                    div.textContent = str;
                    return div.innerHTML;
                }
                
                // Update comment count badge
                function updateCommentCount() {
                    const comments = loadComments();
                    let totalComments = comments.length;
                    
                    // Count replies as well
                    comments.forEach(comment => {
                        if (comment.replies) {
                            totalComments += comment.replies.length;
                        }
                    });
                    
                    commentCountElement.textContent = totalComments;
                }
                
                // Submit comment event listener
                submitButton.addEventListener('click', function() {
                    const name = nameInput.value.trim();
                    const content = contentInput.value.trim();
                    
                    if (name && content) {
                        const comments = loadComments();
                        
                        comments.push({
                            name: name,
                            content: content,
                            timestamp: new Date().getTime(),
                            likes: 0,
                            replies: []
                        });
                        
                        // Save the name for future use
                        localStorage.setItem('remembered_comment_name', name);
                        
                        saveComments(comments);
                        displayComments(comments);
                        updateCommentCount();
                        
                        // Clear inputs
                        nameInput.value = name; // Keep the name for convenience
                        contentInput.value = '';
                    } else {
                        // Show error message if fields are empty
                        if (!name) {
                            nameInput.style.borderColor = 'var(--accent)';
                            nameInput.addEventListener('input', function() {
                                this.style.borderColor = '';
                            }, { once: true });
                        }
                        if (!content) {
                            contentInput.style.borderColor = 'var(--accent)';
                            contentInput.addEventListener('input', function() {
                                this.style.borderColor = '';
                            }, { once: true });
                        }
                    }
                });
                
                // Add sorting functionality
                document.getElementById('comment-sort').addEventListener('change', function() {
                    const sortType = this.value;
                    const comments = loadComments();
                    
                    if (sortType === 'newest') {
                        comments.sort((a, b) => b.timestamp - a.timestamp);
                    } else if (sortType === 'oldest') {
                        comments.sort((a, b) => a.timestamp - b.timestamp);
                    } else if (sortType === 'popular') {
                        comments.sort((a, b) => (b.likes || 0) - (a.likes || 0));
                    }
                    
                    displayComments(comments);
                });
                
                // Remember user's name for convenience
                const rememberedName = localStorage.getItem('remembered_comment_name');
                if (rememberedName) {
                    nameInput.value = rememberedName;
                }
                
                // Initialize
                loadComments();
                updateCommentCount();
                
                // Add enter key support for submitting comments
                contentInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && e.ctrlKey) {
                        submitButton.click();
                    }
                });
            });
            </script>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'Template/Footer.php'; ?>

</body>
</html>