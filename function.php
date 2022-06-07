<?php
class dataFunction
{
    public function __construct()
    {
        session_start();
        $host = "localhost";
        $port = 3307;
        $database = "sqlpaw";
        $username = "root";
        $password = "admin";
        define('MB', 1048576);

        try {
            $this->connection =  new PDO("mysql:host=$host:$port;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function isGuest(): void
    {
        if (isset($_SESSION['login'])) {
            header('location: index.php');
            die();
        }
    }

    public function isLoggedIn(): void
    {
        if (!isset($_SESSION['login'])) {
            header('location: login.php');
            die();
        }
    }

    public function login(array $datas): bool
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$datas['username']]);
        if ($data = $statement->fetch()) {
            if (password_verify($datas['password'], $data['password'])) {
                // 
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['login'] = true;
                $_SESSION['is_admin'] = $data['is_admin'];
                $_SESSION['total_harga'] = 0;

                $_SESSION['flash_message'] = ['sukses' => 'Berhasil Login'];
                return true;
            } else {
                $_SESSION['flash_message'] = ['gagal' => 'Gagal Login!! Username atau Password Salah!!!'];
                return false;
            }
        } else {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Login!! Username atau Password Salah!!!'];
            return false;
        }
    }


    public function register(array $datas): bool
    {
        try {
            $sql = "INSERT INTO users (username,password) VALUES (?,?)";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$datas['username'], password_hash($datas['password'], PASSWORD_DEFAULT)]);
            $_SESSION['flash_message'] = ['sukses' => 'Berhasil Registrasi'];
            return true;
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Registrasi! Username Sudah Ada!!!'];
            return false;
        }
    }

    public function logout(): void
    {
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();

        header('location: login.php');
        die;
    }



    public function addProduct(array $datas, array $file): bool
    {
        $extensi = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($file['error'] = 0 or $file['size'] > 2 * MB) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Menambahkan Produk File Gambar Bermasalah!!!'];
            return false;
        }

        if ($extensi != "jpg" and $extensi != "jpeg" and $extensi != "png") {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Menambahkan Produk File Gambar Bermasalah!!!'];
            return false;
        }
        $namaFile = $datas['product_name'] . "." . $extensi;
        if (file_exists("assets/" . $namaFile)) {
            $namaFile = "dup-" . $namaFile;
        }
        if (!move_uploaded_file($file['tmp_name'], "assets/" . $namaFile)) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Menambahkan Produk!!!'];
            return false;
        }
        try {
            $sql = "INSERT INTO products (image_product,product_name,price,stock) VALUES (?,?,?,?)";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$namaFile, $datas['product_name'], $datas['price'], $datas['stock']]);
            $_SESSION['flash_message'] = ['sukses' => 'Berhasil Menambahkan Produk!!!'];
            return true;
        } catch (PDOException $e) {
            unlink("assets/" . $namaFile);
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Menambahkan Produk!!!'];
            return false;
        }
    }

    public function getAllProduct(): array
    {
        $sql = "SELECT * from products ORDER BY id DESC";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function updateStockProduct($id, $stock): void
    {
        try {
            $sql = "update products set stock = stock+?  where id=?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$stock, $id]);
            $_SESSION['flash_message'] = ['sukses' => 'Berhasil Menambahkan Stock Produk!!!'];
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Menambahkan Stock Produk!!!'];
        }
    }

    public function getProductById($id): array
    {
        $sql = "SELECT * from products where id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetchAll();
    }

    public function editProductById(array $datas): bool
    {
        try {
            $sql = "UPDATE products set image_product = ?,product_name = ?,price = ?,stock = ? WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$datas['image_product'], $datas['product_name'], $datas['price'], $datas['stock'], $datas['id']]);
            $_SESSION['flash_message'] = ['sukses' => 'Berhasil Edit Produk!!!'];
            return true;
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Edit Produk!!!'];
            return false;
        }
    }

    public function deleteProductById($id): bool
    {
        try {
            $sql = "DELETE from products WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$id]);
            $_SESSION['flash_message'] = ['sukses' => 'Berhasil Hapus Produk!!!'];
            if ($statement->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Hapus Produk!!!'];
            return false;
        }
    }

    public function addCart(array $datas): void
    {
        if ($_SESSION['total_harga'] > 0) {
            $_SESSION['total_harga'] += $_POST['harga'] * $_POST['qty'];
        } else {
            $_SESSION['total_harga'] = $_POST['harga'] * $_POST['qty'];
        }
        $_SESSION['barang'][$_POST['id']]['id'] = $_POST['id'];
        $_SESSION['barang'][$_POST['id']]['nama'] = $_POST['nama'];
        $_SESSION['barang'][$_POST['id']]['harga'] = $_POST['harga'];
        if (isset($_SESSION['barang'][$_POST['id']]['qty'])) {
            $_SESSION['barang'][$_POST['id']]['qty'] += $_POST['qty'];
        } else {
            $_SESSION['barang'][$_POST['id']]['qty'] = $_POST['qty'];
        }
    }

    public function delCart($id): void
    {
        $_SESSION['total_harga'] -=  $_SESSION['barang'][$_POST['id']]['qty'] * $_SESSION['barang'][$_POST['id']]['harga'];
        unset($_SESSION['barang'][$_POST['id']]);
    }


    public function addTransactions(string $payment): bool
    {
        try {
            if (!isset($_SESSION['barang'])) {
                $_SESSION['flash_message'] = ['gagal' => 'Gagal Menambahkan Tranksaksi!!!'];
                return false;
            }
            $sql = "INSERT INTO transactions (user_id,total_transaction,payment) VALUES (?,?,?)";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$_SESSION['user_id'], $_SESSION['total_harga'], $payment]);

            $id = $this->connection->lastInsertId();
            foreach ($_SESSION['barang'] as $product) {
                $sqlp = "INSERT INTO detail_transactions (transactions_id,product_id,price,qty) VALUES (?,?,?,?)";
                $statementp = $this->connection->prepare($sqlp);
                $statementp->execute([$id, $product['id'], $product['harga'], $product['qty']]);
            }
            // delete all session cart
            unset($_SESSION['barang']);
            // setup total harga menjadi 0
            $_SESSION['total_harga'] = 0;
            $_SESSION['flash_message'] = ['sukses' => 'Berhasil Menambahkan Tranksaksi!!!'];
            return true;
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Menambahkan Tranksaksi!!!'];
            return false;
        }
    }

    public function delTrasactions($id): bool
    {
        try {
            $sql = "DELETE from transactions WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$id]);
            $_SESSION['flash_message'] = ['sukses' => 'Berhasil Hapus Transaksi!!!'];
            if ($statement->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = ['gagal' => 'Gagal Hapus Transaksi!!!'];
            return false;
        }
    }

    public function getAllTransactions(): array
    {
        $sql = "select transactions.id as tid,payment,total_transaction,time_transaction,username from transactions inner join users on user_id = users.id ORDER BY transactions.id DESC";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getUserTransactions($id): array
    {
        $sql = "select transactions.id as tid,payment,total_transaction,time_transaction from transactions where user_id =? ORDER BY transactions.id DESC";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetchAll();
    }

    public function getTransactionsById($id): array
    {
        if ($_SESSION['is_admin']) {
            $sql = "select product_name,qty,detail_transactions.price as dprice,payment,time_transaction,total_transaction from detail_transactions inner join transactions on  transactions_id = transactions.id inner join products on product_id = products.id where transactions.id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$id]);
            return $statement->fetchAll();
        } else {
            $sql = "select product_name,qty,detail_transactions.price as dprice,payment,time_transaction,total_transaction from detail_transactions inner join transactions on  transactions_id = transactions.id inner join products on product_id = products.id where transactions.id = ? and user_id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$id, $_SESSION['user_id']]);
            return $statement->fetchAll();
        }
    }


    public function __destruct()
    {
        $this->connection = null;
        unset($_SESSION['flash_message']);
    }
}
