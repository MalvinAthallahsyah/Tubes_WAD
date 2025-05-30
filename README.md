<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# FINAL PROJECT

# WEBSITE APPLICATION DEVELOPMENT

Compiled by:  
**CLASS SI 47 INT**  
**Team 4**

| NIM          | Name                                 |
| ------------ | ------------------------------------ |
| 102022340120 | Anak Agung Gde Agung Wira Indramawan |
| 102022340037 | Mohammad Haris Seno                  |
| 102022340119 | Maurithania Joleesha Maria Tjakra    |
| 102022340306 | Gusti Muhammad Malvin Athallahsyah   |
| 102022340392 | Mohammad Naufal Pranantya            |

## BACHELOR'S PROGRAM IN INFORMATION SYSTEMS

## FACULTY OF INDUSTRIAL ENGINEERING

## TELKOM UNIVERSITY

## BANDUNG

## 2025

---

## Table of Contents

-   [Chapter 1 Introduction and Background](#chapter-1-introduction-and-background)
    -   [A. Introduction](#introduction)
    -   [B. Background](#background)
    -   [C. Problem Statement](#problem-statement)
-   [Chapter 2 Proposed Solution and System Design](#chapter-2-proposed-solution-and-system-design)
    -   [A. Proposed Solution](#proposed-solution)
-   [References](#references)

---

## Chapter 1 Introduction and Background

### Introduction

In today's fast-paced digital era, the need for online platforms that connect individuals with shared interests and needs is constantly increasing. With a university environment, especially in Telkom University, which welcomes over 8.000 new students each year, interactions among students are not limited to academic activities alone.
Many students are interested in selling second hand items or launching small businesses, such as selling homemade food or drinks. Unfortunately, there is currently no dedicated campus-supported platform to facilitate these activities.
The internal website we propose aims not only to serve as a transactional platform but also to function as a learning space for practicing entrepreneurship. This will allow students to build real-world business skills in a safe and trustworthy environment.

### Background

Students often have the need and interest to sell personal items they no longer use, such as books, clothes, or electronics. In addition, many students have talents or hobbies in culinary arts and wish to sell their homemade products to fellow students.
The students' enthusiasm for entrepreneurship is also reflected in campus events such as Market Day 2025, which featured 176 student business groups offering a variety of products, from culinary creations to fashion items (Telkom University, 2025).
Currently, there is no official or centralized platform within Telkom University to support these needs. Most students rely on social media, chat groups, or general marketplaces that are not integrated with the campus system. These alternatives come with risks such as scams, limited reach, and difficulty in building trust between buyers and sellers.

### Problem Statement

Telkom University students currently lack an official platform to sell personal items, homemade products, or start small businesses in a secure and trusted environment. This results in several challenges:

-   Limited opportunities for students to express creativity and entrepreneurial spirit.
-   Lack of reliable and accountable selling platforms, as most use external or unofficial services.
-   Difficulty building trust between buyers and sellers due to the absence of proper verification systems.
-   Potential for fraud or unsafe transactions.
-   No structured platform that connects students' needs for academic supplies, dorm essentials, or peer-to-peer services.

---

## Chapter 2 Proposed Solution and System Design

### Proposed Solution

We propose the development of a web-based internal campus marketplace platform specifically designed for Telkom University students. This platform will serve not only as a medium for buying and selling goods and services but also as a safe environment for students to learn and practice entrepreneurship.

The main features include:

**Campus Email Authentication**  
Every user must log in using their official Telkom University email address (@student.telkomuniversity.ac.id). This ensures only active students can access the platform, enhancing security and trust.

**Marketplace Categories**  
To meet various student needs, the platform will support multiple categories, such as:

-   Secondhand Goods: Books, electronics, clothes, and other preloved items.
-   Student-Made Products: Food, beverages, crafts, and handmade items created by students.
-   Student Services: Tutoring, photography, delivery help, design services, and more.

**Rating and Review System**  
Buyers and sellers can leave ratings and reviews after each transaction, promoting transparency and accountability.

**Campus Location Integration**  
Transactions can use a delivery system to designated campus spots or cash-on-delivery (COD) at mutually agreed locations.

**User Dashboards (Seller, Buyer, Admin)**  
Students who want to sell can manage their mini-shop via a personal dashboard, uploading products, setting prices, and managing orders.

**Edupreneurship Integration**  
The platform can be integrated into entrepreneurship courses or programs at Telkom University, allowing students to gain practical experience in running a business while learning.

**In-Platform Direct Chat**  
Users can communicate directly through the in-platform chat feature to discuss product details, negotiate prices, or arrange COD (Cash on Delivery) locations.

**Wishlist**  
Users can save items they are interested in for future reference or purchase. This feature also helps sellers understand which products attract attention.

**Promo & Highlighted Product Section**  
Sellers can feature products for greater visibility. This encourages creativity and competition among sellers.

**Sales and Analytics Overview**  
Sellers can view basic statistics such as number of sales, most-viewed products, and revenue estimates, helping them make informed business decisions.

---

## References

Telkom University. (2025). 176 Student Business Groups from Tel-U Join Market Day 2025 Showcasing Culinary to Fashion Products. Retrieved from https://telkomuniversity.ac.id/176-kelompok-usaha-mahasiswa-tel-u-ramaikan-acara-market-day-2025-sajikan-produk-kuliner-hingga-fashion/
