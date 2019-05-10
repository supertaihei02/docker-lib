FROM alpine:3.3
MAINTAINER @supertaihei02

RUN apk update && apk upgrade && apk add --no-cache \
	bash \
	curl \
	ca-certificates \
	openssl openssl-dev \
	openssh \
	git \
    openntpd \
    nano

ENV PHP_VERSION 5.3.29
ENV PHP_URL="https://museum.php.net/php5/php-${PHP_VERSION}.tar.xz"
ENV PHP_INI_DIR="/etc/php"

RUN set -x \
	&& addgroup -g 82 -S www-data \
    && adduser -u 82 -D -S -G www-data www-data

RUN apk add --no-cache \
    autoconf \
    file \
    g++ \
    gcc \
    make \
    tar \
    xz \
    libc-dev \
    pkgconf \
    curl-dev \
    mysql mysql-dev \
    libxml2-dev \
    libjpeg-turbo-dev \
    libpng-dev

RUN cd /tmp && mkdir php && \
    wget -O php.tar.xz "$PHP_URL" && \
    tar -Jxf "php.tar.xz" -C "/tmp/php" --strip-components=1 && \
    rm "/tmp/php.tar.xz"
RUN cd "/tmp/php" && \
    mkdir -p ${PHP_INI_DIR} && \
    ./configure \
      --disable-cgi \
      --enable-ftp \
      --enable-mbstring \
      --enable-mysqlnd \
      --enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data \
      --disable-cgi \
      --with-config-file-path="$PHP_INI_DIR" \
      --with-config-file-scan-dir="$PHP_INI_DIR/conf.d" \
      --with-curl \
      --with-zlib \
      --with-pdo-mysql \
      --with-mysqli \
      --with-openssl && \
    make && make install && make clean

RUN pear install File_Archive HTML_Template_IT HTTP_Request MIME_Type \
    Net_Socket Net_URL XML_Parser XML_RPC XML_Serializer

# Config
RUN mkdir -p /var/run/php-fpm && \
    mkdir -p /usr/local/etc/php-fpm.d

COPY conf/php.ini ${PHP_INI_DIR}/php.ini
COPY conf/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY conf/www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

# Clear cache
RUN rm -rf /var/cache/apk/*

EXPOSE 9000
CMD ["php-fpm", "-F"]