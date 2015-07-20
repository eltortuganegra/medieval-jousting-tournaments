server{
        server_name medievaljoustingtournaments.dev development.medievaljoustingtournaments.com pre-production.medievaljoustingtournaments.com medievaljoustingtournaments.com;
        access_log /var/www/medieval-jousting-tournaments.com/web_server/nginx/logs/access.log;
        error_log /var/www/medieval-jousting-tournaments.com//web_server/nginx/logs/error.log;
        root /var/www/medieval-jousting-tournaments.com/application;
        index index.php;
        set $yii_bootstrap "index.php";

        charset utf-8;

        location / {
                index  index.html $yii_bootstrap;
                try_files $uri $uri/ /$yii_bootstrap?$args;
        }


        location ~ ^/(protected|framework|themes/\w+/views) {
                deny  all;
        }

        #avoid processing of calls to unexisting static files by yii
        location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
                try_files $uri =404;
        }
        location ~ \.php {
                #location / {
                #let yii catch the calls to unexising PHP files
                fastcgi_split_path_info  ^(.+\.php)(.*)$;
                set $fsn /$yii_bootstrap;
                if (-f $document_root$fastcgi_script_name){
                        set $fsn $fastcgi_script_name;
                }

                fastcgi_pass 127.0.0.1:9000;
                #fastcgi_index index.php;
                include fastcgi_params;
                #fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_param  SCRIPT_FILENAME  $document_root$fsn;

                #PATH_INFO and PATH_TRANSLATED can be omitted, but RFC 3875 specifies them for CGI
                fastcgi_param  PATH_INFO        $fastcgi_path_info;
                fastcgi_param  PATH_TRANSLATED  $document_root$fsn;

                #fastcgi_param PATH_INFO $fastcgi_script_name;
                #access_log off;

        }

        location ~ /\. {
                deny  all;
                access_log off;
                log_not_found off;
        }
        location ~ \.(jpe?g|png|gif)$ {
             valid_referers none blocked campeonatojustasmedievales.pre development.medievaljoustingtournaments.com pre-production.medievaljoustingtournaments.com campeonatojustasmedievales.com;
             if ($invalid_referer) {
                return   403;
            }
        }

}

