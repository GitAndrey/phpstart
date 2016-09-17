<?php

Class Site{
    
    
    public static function getNewsList(){
        
        $db = Db::getConnection();
        
        $newsList = array();
        
        $result = $db->query('SELECT id, title, description, price FROM assort ORDER BY DESC LIMIT 10');
        
        $i=0;
        while($row = $result->fetch()){
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['description'] = $row['description'];
            $newsList[$i]['price'] = $row['price'];
            $i++;
        }
        return $newsList;
    }
    
    public static function getNewsItemById($id){
        
        $db = Db::getConnection();
        
        $result = $db->query('SELECT * FROM assort WHERE id ='.$id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        return $result->fetch();
        
    }
}

