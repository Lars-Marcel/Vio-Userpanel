----------------------------------------------------
------ Copyright (c) FirstOne Media 2014-2016 ------
----------------------------------------------------

local function newTicket(subject, message)
	local player = source
	
	local newMsg = "Spieler "..getPlayerName(player).." ["..timestamp().."]:\n"..message
	
	dbExec ( handler, "INSERT INTO support (ID, player, subject, message, state) VALUES (NULL,?,?,?,?)", getPlayerName(player), subject, message, "open" )
	
	for _, admin in pairs(getElementsByType("player")) do
		if (getElementData(admin, "adminlvl") >= 1) then
			outputChatBox(getPlayerName(player).." benötigt Hilfe!", admin, 255, 155, 0)
		end
	end
	outputChatBox("Ticket erstellt.", player, 0, 255, 0)
end
addEvent("newTicket", true)
addEventHandler("newTicket", root, newTicket)

local function ticketReply(ID, message)
	local player = source
	local sql = dbPoll ( dbQuery ( handler, "SELECT * FROM support WHERE ID=?", ID ), -1 )
	local row = {}
	if (sql and sql[1]) then
		for i, r in ipairs(sql) do
			for column, value in pairs (r) do
				row[column] = value
			end
		end
		
		local state = row['state']
		if (state == "open") then
			local msg = row['message']
			
			local fix = ""
			if (getElementData(player, "adminlvl") >= 1) then
				fix = "Admin"
			else
				fix = "Spieler"
			end
			fix = fix.." "..getPlayerName(player)
			
			local newMsg = fix.." ["..timestamp().."]:\n"..message.."\n\n-----------------\n\n"..msg
			
			dbExec ( handler, "UPDATE support SET message=? WHERE ID=?", newMsg, ID )
			
			local plname = row['player']
			if (plname == getPlayerName(player)) then
				for _, admin in pairs(getElementsByType("player")) do
					if (getElementData(admin, "adminlvl") >= 1) then
						outputChatBox(getPlayerName(player).." hat eine Antwort auf sein Ticket ("..ID..") verfasst!", admin, 255, 155, 0)
					end
				end
			elseif (getPlayerFromName(plname)) then
				outputChatBox("Du hast eine Antwort auf dein Ticket ("..ID..") erhalten.", getPlayerFromName(plname), 255, 155, 0)
			end
			
			outputChatBox("Antwort abgesendet.", player, 0, 255, 0)
		else
			outputChatBox("Fehler: Das Ticket wurde bereits geschlossen.", player, 255, 100, 0)
		end
	else
		outputChatBox("Fehler: Das Ticket mit der ID "..ID.." existiert nicht.", player, 255, 100, 0)
	end
end
addEvent("ticketReply", true)
addEventHandler("ticketReply", root, ticketReply)

local function updateTicketState(ID, state)
	local player = source
	if (state == "open" or state == "closed") then
		local sql = dbPoll ( dbQuery ( handler, "SELECT * FROM support WHERE ID=?", ID ), -1 )
		local row = {}
		if (sql and sql[1]) then
			for i, r in ipairs(sql) do
				for column, value in pairs (r) do
					row[column] = value
				end
			end
			
			local fix = "ge"
			if (state == "open") then
				fix = fix.."öffnet"
			else
				fix = fix.."schlossen"
			end
			outputChatBox("Du hast das Ticket erfolgreich "..fix..".", player, 0, 255, 0)
			
			
			local spieler = row['player']
			local spieler = getPlayerFromName(spieler)
			if (spieler) then
				outputChatBox("Dein Ticket mit der ID "..ID.." wurde von "..getPlayerName(player).." "..fix..".", spieler, 0, 255, 0)
			end
			
			dbExec ( handler, "UPDATE support SET state=? WHERE ID=?", state, ID )
		else
			outputChatBox("Fehler: Das Ticket mit der ID "..ID.." existiert nicht.", player, 255, 100, 0)
		end
	end
end
addEvent("updateTicketState", true)
addEventHandler("updateTicketState", root, updateTicketState)

local function openTicketWindow(player, cmd)
	local tickets = {}
	
	if (cmd == "tickets") then
		sql = dbPoll ( dbQuery ( handler, "SELECT * FROM support", ID ), -1 )
	else
		sql = dbPoll ( dbQuery ( handler, "SELECT * FROM support WHERE player LIKE ?", getPlayerName(player) ), -1 )
	end
	
	for _, row in ipairs(sql) do
		local id = row["ID"]
		tickets[id] = {
			ID = id,
			player = row["player"],
			subject = row["subject"],
			message = row["message"],
			state = row["state"]
		}
	end
	
	if (cmd == "tickets" and getElementData(player, "adminlvl") >= 1) then
		triggerClientEvent(player, "showTicketWindow", player, tickets)
	elseif (cmd == "support" or cmd == "report") then
		triggerClientEvent(player, "showSupportWindow", player, tickets)
	end
	
end
addCommandHandler("tickets", openTicketWindow)
addCommandHandler("support", openTicketWindow)
addCommandHandler("report", openTicketWindow)