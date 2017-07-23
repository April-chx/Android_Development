package com.example.movie_time;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;

import android.util.Log;

public class onMysql {

	public String connectMysql(String gethttp)
    {
        String result = null;
        InputStream is = null;
        StringBuilder sb = null;
        
    	try {
    		HttpClient httpclient = new DefaultHttpClient();
    		HttpGet httpget = new HttpGet(gethttp);
    		HttpResponse response = httpclient.execute(httpget);
    		HttpEntity entity = response.getEntity();
    		is = entity.getContent();
    	} catch (Exception e) {
    		Log.e("log_tag", "Error in http connection" + e.toString());
    	}
    	
    	// convert response to string
    	try {
    		BufferedReader reader = new BufferedReader(new InputStreamReader(is, "iso-8859-1"), 8);
    		sb = new StringBuilder();
    		sb.append(reader.readLine() + "\n");

    		String line = "0";
    		while ((line = reader.readLine()) != null) {
    			sb.append(line + "\n");
    		}
    		is.close();
    		result = sb.toString();
    		
    	} catch (Exception e) {
    		Log.e("log_tag", "Error converting result " + e.toString());
    	}
    	return result;
    }
}
