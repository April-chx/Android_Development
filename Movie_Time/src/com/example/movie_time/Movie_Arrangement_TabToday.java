package com.example.movie_time;

import java.util.ArrayList;
import java.util.HashMap;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.ListActivity;
import android.content.Intent;
import android.net.ParseException;
import android.os.Bundle;

public class Movie_Arrangement_TabToday extends ListActivity{
	
	Intent ma_intent;
	Bundle ma_bundle;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		this.getListView().setBackgroundColor(0xFFFFFFFF);  
		getListView().setCacheColorHint(0);
		
		ma_intent = this.getIntent();
		ma_bundle = ma_intent.getExtras();

		String ma_showtime = "今天";
		String ma_movie = ma_bundle.getString("movie");
		String ma_time = ma_bundle.getString("time");
		String ma_cinema = ma_bundle.getString("cinema");

		// 获取虚拟的数据，数据的格式有严格的要求哦
		ArrayList<HashMap<String, Object>> data = getData(ma_cinema, ma_movie);
		// 模仿SimpleAdapter实现的自己的adapter
		Movie_Arrangement_Adapter movieArrangementAdapter = new Movie_Arrangement_Adapter(
				this, data, ma_showtime, ma_movie, ma_time, ma_cinema);
		setListAdapter(movieArrangementAdapter);
	}

	private ArrayList<HashMap<String, Object>> getData(String cinema, String movie){  
        ArrayList<HashMap<String, Object>> arrayList = new ArrayList<HashMap<String,Object>>(); 
        
    	JSONArray jArray;
		
        onMysql sql = new onMysql();

		try {
			jArray = new JSONArray(
					sql.connectMysql("http://1.movietimeapp.sinaapp.com/movie_arrangement_today_sql.php"));
			JSONObject jsondata = null;
			
			for (int i = 0; i < jArray.length(); i++) {
				jsondata = jArray.getJSONObject(i);
				
				if(jsondata.getString("影院").equals(cinema) && jsondata.getString("片名").equals(movie)){
										
					HashMap<String, Object> tempHashMap = new HashMap<String, Object>();   
				    tempHashMap.put("starttime", jsondata.getString("time_format(时间, '%H:%i')"));  
				    tempHashMap.put("showtype", jsondata.getString("播放类型"));  
				    tempHashMap.put("ticketprice", jsondata.getInt("票价")); 
				    arrayList.add(tempHashMap);  					
				}
           }

		} catch (JSONException e1) {
			// Toast.makeText(getBaseContext(), "No City Found"
			// ,Toast.LENGTH_LONG).show();
		} catch (ParseException e1) {
			e1.printStackTrace();
		}
		 
        return arrayList;  
    }  
}
