package com.learnosity.security;

import java.util.LinkedHashMap;
import java.util.LinkedHashSet;
import java.util.Set;
import java.util.ArrayList;
import java.math.BigInteger;
import java.security.MessageDigest;
import com.google.gson.*;

public class RequestHelper {

	LinkedHashMap<String, Object> securityPacket, requestPacket;
	String secret, jsonRequestString, action;
	String service;

	Set<String> validSecurityKeys = setHash("consumer_key", "domain", "timestamp", "user_id");
	Set<String> validServices = setHash("items");

	String algorithm = "sha256";

	boolean doSignRequestData = true;

	final Gson gson = new Gson();


	public RequestHelper(String service, LinkedHashMap<String, Object> securityPacket, String secret, LinkedHashMap<String, Object> requestPacket, String action) {

		this.validate(service, securityPacket, secret, requestPacket, action);
		this.service = service;
		this.securityPacket = securityPacket;
		this.secret = secret;
		this.requestPacket = requestPacket;
		this.action = action;

		this.securityPacket.put("signature", this.generateSignature());
	}



	public void validate(String service, LinkedHashMap<String, Object> securityPacket, String secret, LinkedHashMap<String, Object> requestPacket, String action) {

		 if (service == null || service.isEmpty()) {
		 	throw new IllegalArgumentException("service must not be null or empty");
		 } else if (!this.validServices.contains(service)) {
		 	throw new IllegalArgumentException("service must a valid service");
		 }

		 for ( String key : securityPacket.keySet() ) {
		 	if (!this.validSecurityKeys.contains(key)) {
		 		throw new IllegalArgumentException("Security packet contains an invalid element");
		 	}
		 }

		 if (secret == null || secret.isEmpty()) {
		 	throw new IllegalArgumentException("secret must not be null or empty");
		 }

	}


	public Set<String> setHash(String... values) {
    	return new LinkedHashSet<String>(java.util.Arrays.asList(values));
	}


	public String generateRequestString(LinkedHashMap<String, Object> originalPacket) {

		if (originalPacket == null) {
			return null;
		} else {
			return gson.toJson(originalPacket);
		}

	}

	public String generateSignature () {


		ArrayList<String> sigArray = new ArrayList<String>();

		for (String elem : this.validSecurityKeys) {
			if(this.securityPacket.containsKey(elem)) {
				sigArray.add(this.securityPacket.get(elem).toString());
			}
		}

		sigArray.add(this.secret);

		if(this.doSignRequestData && this.requestPacket != null) {
			sigArray.add(this.generateRequestString(requestPacket));
		}

		if(this.action != null && !this.action.isEmpty()) {
			sigArray.add(this.action);
		}

	    String[] flattenedArray = new String[sigArray.size()];
    	flattenedArray = sigArray.toArray(flattenedArray); 
    	StringBuilder flattenedToString = new StringBuilder();

    	for (int i = 0; i < flattenedArray.length; i++) {
    		flattenedToString.append(flattenedArray[i]);
    		flattenedToString.append("_");
    	}
    	System.out.println(flattenedToString.toString());
	    try {
	        MessageDigest digest = MessageDigest.getInstance("SHA-256");
	        digest.update(flattenedToString.toString().substring(0, flattenedToString.length() -1).getBytes("UTF-8"));
	        
	        byte[] hash = digest.digest();
	        BigInteger bigInt = new BigInteger(1, hash);
	        return bigInt.toString(16);
	    } 
	    catch (Exception e) {
	        e.printStackTrace(System.err);
	        return null;
	    }
	}

	public String generateRequest () {
		LinkedHashMap<String, Object> output = new LinkedHashMap();

		if( this.service.equalsIgnoreCase("items") ) {
			output.put("security", this.securityPacket);
			if (this.requestPacket !=null) {
				output.put("request", this.requestPacket);
			} 
			if (this.action !=null && !this.action.isEmpty()) {
				output.put("action", this.action);
			} 
		} 

		return gson.toJson(output);
	}

}