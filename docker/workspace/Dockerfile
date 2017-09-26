FROM laradock/workspace:1.8-71

MAINTAINER Vlad Anikin <vanikin@provectus.com>

ARG TZ=UTC
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./composer.json /root/.composer/composer.json

RUN composer global install
RUN echo "" >> ~/.bashrc && \
echo 'export PATH="~/.composer/vendor/bin:$PATH"' >> ~/.bashrc

USER root
COPY ./crontab /etc/cron.d
RUN chmod -R 644 /etc/cron.d

COPY ./aliases.sh /root/aliases.sh
RUN echo "" >> ~/.bashrc && \
    echo "# Load Custom Aliases" >> ~/.bashrc && \
    echo "source /root/aliases.sh" >> ~/.bashrc && \
	echo "" >> ~/.bashrc && \
	sed -i 's/\r//' /root/aliases.sh && \
	sed -i 's/^#! \/bin\/sh/#! \/bin\/bash/' /root/aliases.sh


RUN pecl -q install mongodb && \
    echo "extension=mongodb.so" >> /etc/php/7.1/mods-available/mongodb.ini && \
    ln -s /etc/php/7.1/mods-available/mongodb.ini /etc/php/7.1/cli/conf.d/30-mongodb.ini

RUN printf "\n" | pecl -q install -o -f redis && \
    echo "extension=redis.so" >> /etc/php/7.1/mods-available/redis.ini && \
    phpenmod redis

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www
