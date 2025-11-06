
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    color: #212529;
    overflow-x: hidden;
    scroll-behavior: smooth;
}


@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fadeInUp {
    animation: fadeInUp 0.8s ease forwards;
}


.header-dashboard {
    background: linear-gradient(135deg, #0d6efd, #000000);
    color: white;
    padding: 50px 30px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    margin-bottom: 30px;
    text-align: center;
}

.header-dashboard h1 {
    font-weight: 600;
    font-size: 2rem;
}

.header-dashboard p {
    opacity: 0.9;
    font-size: 1.1rem;
}

/* === SIDEBAR === */
.sidebar {
    height: 100vh;
    border-right: 1px solid #dee2e6;
    background-color: #fff;
    transition: all 0.3s ease;
}

.sidebar .nav-link {
    color: #333;
    font-weight: 500;
    padding: 10px 18px;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: #e9f2ff;
    color: #0d6efd;
    border-left: 4px solid #0d6efd;
}

.sidebar .nav-link.active {
    background-color: #0d6efd;
    color: #fff;
    border-left: 4px solid #084298;
}


.card {
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}


.btn {
    transition: all 0.25s ease;
    border-radius: 8px;
}

.btn:hover {
    transform: scale(1.03);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}


.table-hover tbody tr:hover {
    background-color: #f1f7ff;
}


@media (max-width: 768px) {
    .sidebar {
        height: auto;
    }
}
