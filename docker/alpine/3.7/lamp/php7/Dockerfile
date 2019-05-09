FROM alpine:3.7
MAINTAINER @supertaihei02

RUN apk update && apk upgrade && apk add \
	bash \
	apache2 \
	curl \
	ca-certificates \
	openssl \
	openssh \
	git \
    tzdata \
    openntpd \
    nano

# Config
COPY conf/httpd.conf /etc/apache2/httpd.conf
COPY conf/php.ini /etc/php7/php.ini

# PHP7
RUN apk add php7 php7-common php7-apache2 php7-phar php7-json php7-iconv php7-openssl php7-mbstring php7-mcrypt php7-pdo php7-mysqli php7-ctype


# Clear cache
RUN rm -rf /var/cache/apk/* &&\
    rm -rf /run/apache2 &&\
    mkdir -p /run/apache2

EXPOSE 80
CMD [ "/usr/sbin/httpd", "-D", "FOREGROUND" ]