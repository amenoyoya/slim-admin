FROM mysql:5.7

# my.cnf は パーミッション644 にする必要がある
ADD ./my.cnf /etc/mysql/my.cnf
RUN chmod 644 /etc/mysql/my.cnf

WORKDIR /var/lib/mysql
