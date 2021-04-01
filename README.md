# inf011-abstract-factory
Desenvolvimento do trabalho solicitado na disciplina de design patterns, para implementação de aplicação baseada em plugins que faça syntax highlight e compile código.


# Instruções
 - Execute o comando ```docker-compose up -d``` para montar e iniciar o container web
 - Execute o comando ```php docker exec web composer install && docker exec --user root web chmod 777 -R .``` para instalar todas as dependências
 - Abra algum web browser no endereço http://localhost:8080
