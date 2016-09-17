<?php

class News{
    public static function getNewsItemById($id){

        //Подключанмся к базе
        $db = Db::getConnection();
        
        //Делаем выборку
        $result = $db->query('SELECT * FROM news WHERE id = '.$id);
        
        //Переводим в асоциативный массив 
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        return $result->fetch();
        
    }
    
    public static function getNewsList(){

        $db = Db::getConnection();
        $newslist = array();
        
        $result = $db->query('SELECT id, title, date, excerpt FROM news ORDER BY date DESC LIMIT 10');
        
        $i = 0;
        while($row = $result->fetch()){
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['date'] = $row['date'];
            $newsList[$i]['excerpt'] = $row['excerpt'];
            $i++;
        }
        return $newsList;
        
        
    }
}