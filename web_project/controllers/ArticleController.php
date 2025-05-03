<?php
require_once __DIR__ . '/../models/ArticleModel.php';


class ArticleController {
    private $model;

    public function __construct($conn) {
        $this->model = new ArticleModel($conn);
    }

    public function list() {
        $articles = $this->model->getAllArticles();
    
        if (!$articles) {
            echo "⚠️ Không lấy được dữ liệu từ model.";
        }
    
        include 'views/client/article_list.php';
    }
    
    public function detail() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "Bài viết không tồn tại.";
            return;
        }
        $id = (int)$_GET['id'];
        $article = $this->model->getArticleById($id);
        if (!$article) {
            echo "Không tìm thấy bài viết.";
            return;
        }
        include 'views/client/article.php';
    }
}
?>
