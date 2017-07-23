package com.example.movie_time;

import java.util.ArrayList;
import java.util.HashMap;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.net.ParseException;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;

public class Searching_Activity extends Activity {
	 
	 private EditText s_edittext;  
	 private ListView s_listview;  
	 private Searching_Adapter searchAdapter;  

	 ArrayList<HashMap<String, Object>> movie_arrayList = new ArrayList<HashMap<String, Object>>();
	 ArrayList<HashMap<String, Object>> cinema_arrayList = new ArrayList<HashMap<String, Object>>();
	 ArrayList<HashMap<String, Object>> new_arrayList = new ArrayList<HashMap<String, Object>>(); 
	    
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState); 
		setContentView(R.layout.searching);
		
		init();  
        initDefaultLists(); 
        
        Button s_imbutton = (Button) findViewById(R.id.button1);
		s_imbutton.setOnClickListener(new Button.OnClickListener() {
			public void onClick(View v) {
				Searching_Activity.this.finish();
			}
		});
	}
	
	//��ʼ���ؼ�  
    private void init() {  
    	s_edittext = (EditText) findViewById(R.id.searchbox);  
        //Ϊ�������TextWatcher�������ֵı仯  
    	s_edittext.addTextChangedListener(new TextWatcher_Enum());  
        s_listview = (ListView) findViewById(R.id.list);   
        s_listview.setOnItemClickListener(new onclick());  
    }  
  
    //�������  
    private void initDefaultLists() {  
    	
    	String s_poster;
		String s_movie; 
		String s_cinema;
		String s_address;
		String s_phone;

		JSONArray movie_jArray;
		JSONArray cinema_jArray;
		JSONObject movie_jsondata = null;
		JSONObject cinema_jsondata = null;

		onMysql movie_sql = new onMysql();
		onMysql cinema_sql = new onMysql();
		

		try {
			movie_jArray = new JSONArray(
					movie_sql.connectMysql("http://1.movietimeapp.sinaapp.com/movie_list_sql.php"));
			cinema_jArray = new JSONArray(
					cinema_sql.connectMysql("http://1.movietimeapp.sinaapp.com/cinema_list_sql.php"));

			for (int i1 = 0; i1 < movie_jArray.length(); i1++) {
				movie_jsondata = movie_jArray.getJSONObject(i1);
				
				s_movie = movie_jsondata.getString("Ƭ��");
				s_poster = movie_jsondata.getString("����");
				
				HashMap<String, Object> tempHashMap = new HashMap<String, Object>();
				tempHashMap.put("position", i1);
				tempHashMap.put("sign", "movie_sign");
				tempHashMap.put("item", "ӰƬ��");
				tempHashMap.put("name", s_movie);
				tempHashMap.put("poster", s_poster);
				movie_arrayList.add(tempHashMap);

			}

			for (int i2 = 0; i2 < cinema_jArray.length(); i2++) {
				cinema_jsondata = cinema_jArray.getJSONObject(i2);

				s_cinema = cinema_jsondata.getString("ӰԺ");
				s_address = cinema_jsondata.getString("��ַ");
				s_phone = cinema_jsondata.getString("�绰");
				
				HashMap<String, Object> tempHashMap = new HashMap<String, Object>();
				tempHashMap.put("position", i2);
				tempHashMap.put("sign", "cinema_sign");
				tempHashMap.put("item", "ӰԺ��");
				tempHashMap.put("name", s_cinema);
				tempHashMap.put("poster", "no poster");
				tempHashMap.put("address", s_address);
				tempHashMap.put("phone", s_phone);
				cinema_arrayList.add(tempHashMap);

			}

		} catch (JSONException e1) {
			// Toast.makeText(getBaseContext(), "No City Found"
			// ,Toast.LENGTH_LONG).show();
		} catch (ParseException e1) {
			e1.printStackTrace();
		}
    }  
  
    //��editetext�仯ʱ���õķ��������ж��������Ƿ����������������  
    private ArrayList<HashMap<String, Object>> getData(String input) {  
    	
    	//String tempName = null;
        //����list      
        for (int j1 = 0; j1 < movie_arrayList.size(); j1++) {  
        	String tempName = (String) movie_arrayList.get(j1).get("name");  
            //��������������ְ����������ַ���  
            if (tempName.contains(input) && !input.equals("")) {  
                //����������Ԫ���������һ��list  
            	HashMap<String, Object> tempHashMap = new HashMap<String, Object>();  
            	tempHashMap.put("position", (Integer) movie_arrayList.get(j1).get("position"));
            	tempHashMap.put("sign", (String) movie_arrayList.get(j1).get("sign"));
				tempHashMap.put("item", (String) movie_arrayList.get(j1).get("item"));
				tempHashMap.put("name", tempName);
				tempHashMap.put("poster", (String) movie_arrayList.get(j1).get("poster"));
				new_arrayList.add(tempHashMap); 
            }  
        }  
        
        for (int j2 = 0; j2 < cinema_arrayList.size(); j2++) {  
        	String tempName = (String) cinema_arrayList.get(j2).get("name");  
            //��������������ְ����������ַ���  
            if (tempName.contains(input) && !input.equals("")) {  
                //����������Ԫ���������һ��list  
            	HashMap<String, Object> tempHashMap = new HashMap<String, Object>();  
            	tempHashMap.put("position", (Integer) cinema_arrayList.get(j2).get("position"));
            	tempHashMap.put("sign", (String) cinema_arrayList.get(j2).get("sign"));
				tempHashMap.put("item", (String) cinema_arrayList.get(j2).get("item"));
				tempHashMap.put("name", tempName);
				tempHashMap.put("poster", "no poster");
				new_arrayList.add(tempHashMap); 
            }  
        }  
        return new_arrayList;  
    }  
  
    //button�ĵ���¼�  
	class onclick implements OnItemClickListener {

		@Override
		public void onItemClick(AdapterView<?> parent, View view, int position,
				long id) {

			String click_item = (String) new_arrayList.get(position).get("item");
			
			if (click_item.equals("ӰƬ��")) {
				Intent intent = new Intent();
				intent.setClass(Searching_Activity.this,
						Movie_Introduction_Activity.class);

				String click_poster = (String) new_arrayList.get(position).get(
						"poster");						
				Bundle bundle = new Bundle();
				bundle.putString("url",
						"http://1.movietimeapp.sinaapp.com/submissions/"
								+ click_poster);
				bundle.putInt("position", (Integer)new_arrayList.get(position).get("position"));
				intent.putExtras(bundle);

				Searching_Activity.this.startActivity(intent);
			}
			else if(click_item.equals("ӰԺ��")){
				
				Intent intent = new Intent();
				intent.setClass(Searching_Activity.this,
						Cinema_Introduction_Activity.class);
					
				Bundle bundle = new Bundle();
				int cinema_position = (Integer)new_arrayList.get(position).get("position");
				bundle.putString("name",(String)cinema_arrayList.get(cinema_position).get("name"));
				bundle.putString("address", (String)cinema_arrayList.get(cinema_position).get("address"));
				bundle.putString("phone", (String)cinema_arrayList.get(cinema_position).get("phone"));

				intent.putExtras(bundle);

				Searching_Activity.this.startActivity(intent);
				
			}
		}

	}
  
    //TextWatcher�ӿ�  
    class TextWatcher_Enum implements TextWatcher {  
  
        //���ֱ仯ǰ  
        @Override  
        public void beforeTextChanged(CharSequence s, int start, int count,  
                int after) {  
  
        }  
  
        //���ֱ仯ʱ  
        @Override  
        public void onTextChanged(CharSequence s, int start, int before,  
                int count) {  
        	
        	new_arrayList.clear();  
            if (s_edittext.getText() != null) {  
            	
                String input = s_edittext.getText().toString();  
                new_arrayList = getData(input);  
                searchAdapter = new Searching_Adapter(Searching_Activity.this, new_arrayList);  
                s_listview.setAdapter(searchAdapter);  
            }
        }  
  
        //���ֱ仯��  
        @Override  
        public void afterTextChanged(Editable s) {  
  
        }  
    } 

}
