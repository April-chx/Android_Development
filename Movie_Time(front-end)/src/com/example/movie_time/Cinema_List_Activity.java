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
import android.util.Log;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.TextView;

public class Cinema_List_Activity extends ListActivity{
    
	Intent ci_intent1;
	Bundle ci_bundle1;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.cinema_list);
		
		ci_intent1 = this.getIntent();
		ci_bundle1 = ci_intent1.getExtras();		
		String ci_movie = ci_bundle1.getString("movie");
		String ci_time = ci_bundle1.getString("time");
		String ci_movietype = ci_bundle1.getString("movietype");
		String ci_url = ci_bundle1.getString("url");
		
		// ��ȡ��������ݣ����ݵĸ�ʽ���ϸ��Ҫ��Ŷ  
        ArrayList<HashMap<String, Object>> data = getData(ci_movie);  
        //ģ��SimpleAdapterʵ�ֵ��Լ���adapter  
        Cinema_List_Adapter cinemaListAdapter = new Cinema_List_Adapter(this, data, ci_movie, ci_time, ci_movietype, ci_url);        
        setListAdapter(cinemaListAdapter);  
        
        TextView ci_teview = (TextView)findViewById(R.id.textView1);
        ci_teview.append(ci_movie);
        
        ImageButton ci_imbutton = (ImageButton) findViewById(R.id.imageButton1);
		ci_imbutton.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Cinema_List_Activity.this.finish();
			}
		});
		
		ImageButton mi_imbutton2 = (ImageButton) findViewById(R.id.imageButton2);
		mi_imbutton2.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Intent intent = new Intent();
				intent.setClass(Cinema_List_Activity.this, Main_Interface_Activity.class);
				
				Cinema_List_Activity.this.startActivity(intent);
			}
		});
	}
	
	/** 
     * @author chenzheng_java 
     * @description ׼��һЩ�������� 
     * @return һ��������������Ϣ��hashMap���� 
     */
	private ArrayList<HashMap<String, Object>> getData(String movie){  
        ArrayList<HashMap<String, Object>> arrayList = new ArrayList<HashMap<String,Object>>(); 
        
        String ci_cinema;  
        String ci_address;
    	JSONArray cinema_jArray;
    	JSONArray address_jArray;
		
        onMysql cinema_sql = new onMysql();
        onMysql address_sql = new onMysql();

		try {
			cinema_jArray = new JSONArray(
					cinema_sql.connectMysql("http://1.movietimeapp.sinaapp.com/cinema_list_for_movie_sql.php"));
			address_jArray = new JSONArray(
					address_sql.connectMysql("http://1.movietimeapp.sinaapp.com/cinema_list_sql.php"));
			JSONObject cinema_jsondata = null;
			
			for (int i = 0; i < cinema_jArray.length(); i++) {
				cinema_jsondata = cinema_jArray.getJSONObject(i);
				
				if(cinema_jsondata.getString("Ƭ��").equals(movie)){
					
					JSONObject address_jsondata = null;
					
					for(int j = 0; j < address_jArray.length(); j++){
						
						address_jsondata = address_jArray.getJSONObject(j);
						
						if(address_jsondata.getString("ӰԺ").equals(cinema_jsondata.getString("ӰԺ"))){
							ci_cinema = cinema_jsondata.getString("ӰԺ");
							ci_address = address_jsondata.getString("��ַ");
							
							HashMap<String, Object> tempHashMap = new HashMap<String, Object>();   
				            tempHashMap.put("cinema", ci_cinema);  
				            tempHashMap.put("address", ci_address);  
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
  
//    @Override  
//    protected void onListItemClick(ListView l, View v, int position, long id) {  
//          
//        Log.i("�����Ϣ",v.toString() );  
//    }
}
