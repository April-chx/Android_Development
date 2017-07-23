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

public class Cinema_Introduction_TabTomorrow extends ListActivity{
	
	Intent ci_intent;
	Bundle ci_bundle;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		//防止滑动背景变黑
		this.getListView().setBackgroundColor(0xFFFFFFFF);  
		getListView().setCacheColorHint(0);
		
		ci_intent = this.getIntent();
		ci_bundle = ci_intent.getExtras();

		String ci_cinema = ci_bundle.getString("cinema");
		String ci_address = ci_bundle.getString("address");
		// 获取虚拟的数据，数据的格式有严格的要求哦
		ArrayList<HashMap<String, Object>> data = getData(ci_cinema);
		// 模仿SimpleAdapter实现的自己的adapter
		Cinema_Introduction_Adapter cinemaIntroductionAdapter = new Cinema_Introduction_Adapter(
				this, data, ci_cinema, ci_address);
		setListAdapter(cinemaIntroductionAdapter);
	}
	
	private ArrayList<HashMap<String, Object>> getData(String cinema){
		
		ArrayList<HashMap<String, Object>> arrayList = new ArrayList<HashMap<String,Object>>(); 
        
    	JSONArray movie_jArray;
    	JSONArray info_jArray;
		
        onMysql movie_sql = new onMysql();
        onMysql info_sql = new onMysql();

		try {
			movie_jArray = new JSONArray(
					movie_sql.connectMysql("http://1.movietimeapp.sinaapp.com/cinema_introduction_tomorrow_sql.php"));
			info_jArray = new JSONArray(
					info_sql.connectMysql("http://1.movietimeapp.sinaapp.com/movie_list_sql.php"));
			JSONObject movie_jsondata = null;
			
			for (int i = 0; i < movie_jArray.length(); i++) {
				
				movie_jsondata = movie_jArray.getJSONObject(i);				
				if(movie_jsondata.getString("影院").equals(cinema)){
					
					JSONObject info_jsondata = null;
					for (int j = 0; j < info_jArray.length(); j++) {
						
						info_jsondata = info_jArray.getJSONObject(j);
						if(info_jsondata.getString("片名").equals(movie_jsondata.getString("片名")))
						{
							HashMap<String, Object> tempHashMap = new HashMap<String, Object>();
							tempHashMap.put("movie_position", j);
							tempHashMap.put("movie_name", info_jsondata.getString("片名"));
							tempHashMap.put("movie_time", info_jsondata.getString("电影时长"));
							tempHashMap.put("movie_type", info_jsondata.getString("影片类型"));
							tempHashMap.put("movie_url", "http://1.movietimeapp.sinaapp.com/submissions/"+info_jsondata.getString("海报"));
							arrayList.add(tempHashMap);
						}
					}
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
