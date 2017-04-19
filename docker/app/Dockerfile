FROM phalconphp/php-apache:ubuntu-16.04
MAINTAINER Serghei Iakovlev <serghei@phalconphp.com>
ENV PROVISION_CONTEXT "development"
COPY bin/*.sh /opt/docker/provision/entrypoint.d/
RUN \
    # Custom provisions
    chmod +x /opt/docker/provision/entrypoint.d/*.sh \
